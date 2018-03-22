<?php

namespace App\Http\Controllers\Auth;

use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Events\User\Registered;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginPinRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mailers\UserMailer;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Services\Auth\TwoFactor\Contracts\Authenticatable;
use App\Support\Enum\UserStatus;
use Auth;
use Authy;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lang;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;
use Session;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * Create a new authentication controller instance.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('guest', ['except' => ['getLogout']]);
        $this->middleware('auth', ['only' => ['getLogout']]);
        $this->middleware('registration', ['only' => ['getRegister', 'postRegister']]);
        $this->users = $users;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        session()->put('login', 'panel');

        $socialProviders = config('auth.social.providers');

        return view('auth.login', compact('socialProviders'));
    }

    /**
     * Show the application login form by PIN.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoginPin()
    {
        session()->put('login', 'pin');

        return view('auth.loginPin');
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        // In case that request throttling is enabled, we have to check if user can perform this request.
        // We'll key this by the username and the IP address of the client making these requests into this application.
        $throttles = Config('auth.throttle_enabled');

        //Redirect URL that can be passed as hidden field.
        $to = $request->has('to') ? "?to=" . $request->get('to') : '';

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (! Auth::validate($credentials)) {

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            return redirect()->to('panel' . $to)
                ->withErrors(trans('auth.failed'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if ($user->isUnconfirmed()) {
            return redirect()->to('panel' . $to)
                ->withErrors(trans('app.please_confirm_your_email_first'));
        }

        if ($user->isBanned()) {
            return redirect()->to('panel' . $to)
                ->withErrors(trans('app.your_account_is_banned'));
        }

        Auth::login($user, $request->get('remember'));

        return $this->handleUserWasAuthenticated($request, $throttles, $user);
    }

    /**
     * Handle a login request to the application by Pin.
     *
     * @param LoginPinRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postLoginPin(LoginPinRequest $request)
    {
        $throttles = Config('auth.throttle_enabled');
        $username = $request->get('username');
        $password = $request->get('pin-1').$request->get('pin-2').$request->get('pin-3').$request->get('pin-4');

        $credentials = $this->getPinCredentials($username, $password);

        if (! Auth::validate($credentials)) {

            return redirect()->to('login-pin')->withErrors(trans('auth.failed'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if ($user->isBanned()) {
            return redirect()->to('login-pin')->withErrors(trans('app.your_account_is_banned'));
        }

        Auth::login($user, true);

        $user->update(['last_login' => Carbon::now()]);

        session()->put('username', $user->username);

        return redirect()->intended('/dashboard');
    }

    /**
     * Handle a login request to the application by Pin.
     *
     * @param LoginPinRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postLoginPinSearch(Request $request)
    {
        $throttles = Config('auth.throttle_enabled');
        $username = $request->get('username');
        $password = $request->get('pin');

        $credentials = $this->getPinCredentials($username, $password);

        if (! Auth::validate($credentials)) {
            $response = [
                'success' => false,
                'status' => 'error',
                'message' => trans('auth.failed')
            ];
        } else {
            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            if ($user->isBanned()) {
                $response = [
                    'success' => false,
                    'status' => 'error',
                    'message' => trans('app.your_account_is_banned')
                ];
            } else {
                $response = [
                    'success' => true,
                    'user_id' => $user->id
                ];
            }
        } 

        return response()->json($response);
    }

    /**
     * Handle a login request to the application by nick.
     *
     * @param LoginPinRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postLoginNickSearch(Request $request)
    {
        $throttles = Config('auth.throttle_enabled');
        $username = $request->get('username');

        $user = $this->users->where('username', $username)->first();

        if (! $user ) {
            $response = [
                'success' => false,
                'status' => 'error',
                'message' => 'El usuario no existe.'
            ];
        } else {

            if ($user->isBanned()) {
                $response = [
                    'success' => false,
                    'status' => 'error',
                    'message' => trans('app.your_account_is_banned')
                ];
            } else {
                $response = [
                    'success' => true,
                    'user_id' => $user->id
                ];
            }
        } 

        return response()->json($response);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  Request  $request
     * @return array
     */
    protected function getPinCredentials($username, $password)
    {
        $usernameOrEmail = $username;

        if ($this->isEmail($usernameOrEmail)) {
            return [
                'email' => $usernameOrEmail,
                'password' => $password
            ];
        }

        return [
            'username' => $usernameOrEmail,
            'password' =>  $password
        ];
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  Request $request
     * @param  bool $throttles
     * @param $user
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles, $user)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        $this->users->update($user->id, ['last_login' => Carbon::now()]);

        event(new LoggedIn($user));

        if ($request->has('to') && !Auth::user()->hasRole('dj')) {
            return redirect()->to($request->get('to'));
        }

        return redirect()->intended('/dashboard');
    }

    protected function logoutAndRedirectToTokenPage(Request $request, Authenticatable $user)
    {
        Auth::logout();

        $request->session()->put('auth.2fa.id', $user->id);

        return redirect()->route('auth.token');
    }

    public function getToken()
    {
        return session('auth.2fa.id') ? view('auth.token') : redirect('panel');
    }

    public function postToken(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        if (! session('auth.2fa.id')) {
            return redirect('login');
        }

        $user = $this->users->find(
            $request->session()->pull('auth.2fa.id')
        );

        if ( ! $user) {
            throw new NotFoundHttpException;
        }

        if (! Authy::tokenIsValid($user, $request->token)) {
            return redirect()->to('panel')->withErrors(trans('app.2fa_token_invalid'));
        }

        Auth::login($user);

        event(new LoggedIn($user));

        return redirect()->intended('/dashboard');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        // The form field for providing username or password
        // have name of "username", however, in order to support
        // logging users in with both (username and email)
        // we have to check if user has entered one or another
        $usernameOrEmail = $request->get($this->loginUsername());

        if ($this->isEmail($usernameOrEmail)) {
            return [
                'email' => $usernameOrEmail,
                'password' => $request->get('password')
            ];
        }

        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        event(new LoggedOut(Auth::user()));

        $role = Auth::user()->hasRole('user');

        Session::forget('branch_office');
        Session::forget('branch_offices');
        Session::forget('to_reservation');

        Auth::logout();

        if ($role) {
            if(Session::get('login') == 'pin') {
                return redirect('login-pin');
            }
            return redirect('login');
        }

        return redirect('panel');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'username';
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return app(RateLimiter::class)->tooManyAttempts(
            $request->input($this->loginUsername()).$request->ip(),
            $this->maxLoginAttempts(), $this->lockoutTime() / 60
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function incrementLoginAttempts(Request $request)
    {
        app(RateLimiter::class)->hit(
            $request->input($this->loginUsername()).$request->ip()
        );
    }

    /**
     * Determine how many retries are left for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function retriesLeft(Request $request)
    {
        $attempts = app(RateLimiter::class)->attempts(
            $request->input($this->loginUsername()).$request->ip()
        );

        return $this->maxLoginAttempts() - $attempts + 1;
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $request->input($this->loginUsername()).$request->ip()
        );

        return redirect('panel')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getLockoutErrorMessage($seconds),
            ]);
    }

    /**
     * Get the login lockout error message.
     *
     * @param  int  $seconds
     * @return string
     */
    protected function getLockoutErrorMessage($seconds)
    {
        return trans('auth.throttle', ['seconds' => $seconds]);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        app(RateLimiter::class)->clear(
            $request->input($this->loginUsername()).$request->ip()
        );
    }

    /**
     * Get the maximum number of login attempts for delaying further attempts.
     *
     * @return int
     */
    protected function maxLoginAttempts()
    {
        return Config('auth.throttle_attempts', 5);
    }

    /**
     * The number of seconds to delay further login attempts.
     *
     * @return int
     */
    protected function lockoutTime()
    {
        $lockout = (int) Config('auth.throttle_lockout_time');

        if ($lockout <= 1) {
            $lockout = 1;
        }

        return 60 * $lockout;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register-pin');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @param UserMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterRequest $request, UserMailer $mailer, RoleRepository $roles)
    {
        $status = UserStatus::ACTIVE;
        $password = $this->generateRandomString(4);
        //$password = $request->get('pin-1').$request->get('pin-2').$request->get('pin-3').$request->get('pin-4');

        // Add the user to database
        $user = $this->users->create(array_merge(
            $request->only('email', 'username', 'first_name', 'last_name'),
            [
                'status' => $status,
                'password' => $password,
                'client_id' => $this->getClientNumber()
            ]
        ));

        $mailer->sendPin($user, $password);

        $this->users->updateSocialNetworks($user->id, []);

        $role = $roles->findByName('User');
        $this->users->setRole($user->id, $role->id);
        $message = trans('app.email_pin_create_can_login');

        return redirect('login')->with('success', $message);
    }

    public function getClientNumber(){
     do{
        $rand = $this->generateRandomString(4);
      }while(! empty($this->users->where('client_id',$rand)->first()) );

       return $rand;
    }

    /**
     * generate random pin
     *
     */
    public function generateRandomString($length) {
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
     }

    /**
     * Confirm user's email.
     *
     * @param $token
     * @return $this
     */
    public function confirmEmail($token)
    {
        if ($user = $this->users->findByConfirmationToken($token)) {
            $this->users->update($user->id, [
                'status' => UserStatus::ACTIVE,
                'confirmation_token' => null
            ]);

            return redirect()->to('panel')
                ->withSuccess(trans('app.email_confirmed_can_login'));
        }

        return redirect()->to('panel')
            ->withErrors(trans('app.wrong_confirmation_token'));
    }

    /**
     * Validate if provided parameter is valid email.
     *
     * @param $param
     * @return bool
     */
    private function isEmail($param)
    {
        return ! Validator::make(
            ['username' => $param],
            ['username' => 'email']
        )->fails();
    }

    /**
     * @param UserMailer $mailer
     * @param $user
     */
    private function sendConfirmationEmail(UserMailer $mailer, $user)
    {
        $token = str_random(60);
        $this->users->update($user->id, ['confirmation_token' => $token]);
        $mailer->sendConfirmationEmail($user, $token);
    }

    /**************************** User Client **********************************/

    /**
     * Show the application login form user client.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoginFacebook()
    {
        session()->put('login', 'user');

        return view('auth.login_facebook');
    }

}
