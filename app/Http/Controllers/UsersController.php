<?php

namespace App\Http\Controllers;

use App\Events\User\Created;
use App\Events\User\Banned;
use App\Events\User\Deleted;
use App\Events\User\UpdatedByAdmin;
use App\Events\User\UpdatedProfileDetails;
use App\Events\User\UpdatedProfileLogin;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateProfileDetailsRequest;
use App\Http\Requests\User\UpdateDetailsRequest;
use App\Http\Requests\User\UpdateLoginDetailsRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Session\SessionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Upload\UserAvatarManager;
use App\Support\Enum\UserStatus;
use App\Mailers\UserMailer;
use App\User;
use Auth;
use Authy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Repositories\BranchOffice\BranchOfficeRepository;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users, BranchOfficeRepository $branch_offices)
    {
        $this->middleware('auth');
        //$this->middleware('role:superAdmin');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        $this->users = $users;
        $this->branch_offices = $branch_offices;
    }

    /**
     * Display paginated list of all users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $perPage = 10;

        $users = $this->users->index($perPage, Input::get('search'), Input::get('status'));
        $statuses = ['' => trans('app.all')] + UserStatus::lists();

        return view('user.list', compact('users', 'statuses'));
    }

    /**
     * Displays user profile page.
     *
     * @param User $user
     * @param ActivityRepository $activities
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(User $user, ActivityRepository $activities)
    {
        $socialNetworks = $user->socialNetworks;

        $userActivities = $activities->getLatestActivitiesForUser($user->id, 10);

        return view('user.view', compact('user', 'socialNetworks', 'userActivities'));
    }

    /**
     * Displays form for creating a new user.
     *
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleRepository $roleRepository)
    {
        $roles = $roleRepository->lists();

        return view('user.add', compact('roles'));
    }

    /**
     * Stores new user into the database.
     *
     * @param CreateUserRequest $request
     * @return mixed
     */
    public function store(CreateUserRequest $request)
    {
        // When user is created by administrator, we will set his
        // status to Active by default.
        $data = $request->all() + ['status' => UserStatus::ACTIVE];

        $data['username'] = null;

        $user = $this->users->create($data);
        $this->users->setRole($user->id, $request->get('role'));

        event(new Created($user));

        return redirect()->route('user.list')
            ->withSuccess(trans('app.user_created'));
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

    /**
     * Displays edit user form.
     *
     * @param User $user
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user, RoleRepository $roleRepository)
    {
        $roles = $roleRepository->lists();
        $statuses = UserStatus::lists();
        $branch_offices = $this->branch_offices->lists_actives();

        return view('user.edit',
            compact('user', 'roles', 'statuses', 'branch_offices'));
    }

    /**
     * Updates user details.
     *
     * @param User $user
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(User $user, UpdateProfileDetailsRequest $request)
    {
        $this->users->update($user->id, $request->all());

        event(new UpdatedProfileDetails($user));

        // If user status was updated to "Banned",
        // fire the appropriate event.
        if ($this->userIsBanned($user, $request)) {
            event(new Banned($user));
        }

        return redirect()->back()
            ->withSuccess(trans('app.user_updated'));
    }

    /**
     * Updates user by superadmin o admin.
     *
     * @param User $user
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetailsByAdmin(User $user, Request $request)
    {
        $this->users->update($user->id, $request->all());
        $this->users->setRole($user->id, $request->get('role'));

        event(new UpdatedByAdmin($user));

        // If user status was updated to "Banned",
        // fire the appropriate event.
        if ($this->userIsBanned($user, $request)) {
            event(new Banned($user));
        }

        return redirect()->back()
            ->withSuccess(trans('app.user_updated'));
    }

    /**
     * Check if user is banned during last update.
     *
     * @param User $user
     * @param Request $request
     * @return bool
     */
    private function userIsBanned(User $user, Request $request)
    {
        return $user->status != $request->status && $request->status == UserStatus::BANNED;
    }

    /**
     * Update user's avatar from uploaded image.
     *
     * @param User $user
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatar(User $user, UserAvatarManager $avatarManager)
    {
        $name = $avatarManager->uploadAndCropAvatar($user);

        $this->users->update($user->id, ['avatar' => $name]);

        event(new UpdatedByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.avatar_changed'));
    }

    /**
     * Update user's avatar from some external source (Gravatar, Facebook, Twitter...)
     *
     * @param User $user
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatarExternal(User $user, Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded($user);

        $this->users->update($user->id, ['avatar' => $request->get('url')]);

        event(new UpdatedByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.avatar_changed'));
    }

    /**
     * Update user's login details.
     *
     * @param User $user
     * @param UpdateLoginDetailsRequest $request
     * @return mixed
     */
    public function updateLoginDetails(User $user, UpdateLoginDetailsRequest $request)
    {
        $data = $request->all();

        if (trim($data['password']) == '') {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->users->update($user->id, $data);

        event(new UpdatedProfileLogin($user));

        return redirect()->back()->withSuccess(trans('app.login_updated'));
    }

    /**
     * Removes the user from database.
     *
     * @param Request $request
     * @return $this
     */
    public function delete(Request $request)
    {
        $user = $this->users->find($request->id);
        if ($user->id == Auth::id()) {
            return response()->json([
                'success'=> false, 
                'message' => trans('app.you_cannot_delete_yourself')
            ]);
        }

        $destroy = $this->users->delete($user->id);

        event(new Deleted($user));

        return response()->json(['success'=> true]);

    }

    /**
     * Enables Authy Two-Factor Authentication for user.
     *
     * @param User $user
     * @param EnableTwoFactorRequest $request
     * @return $this
     */
    public function enableTwoFactorAuth(User $user, EnableTwoFactorRequest $request)
    {
        if (Authy::isEnabled($user)) {
            return redirect()->route('user.edit', $user->id)
                ->withErrors(trans('app.2fa_already_enabled_user'));
        }

        $user->setAuthPhoneInformation($request->country_code, $request->phone_number);

        Authy::register($user);

        $user->save();

        event(new TwoFactorEnabledByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.2fa_enabled'));
    }

    /**
     * Disables Authy Two-Factor Authentication for user.
     *
     * @param User $user
     * @return $this
     */
    public function disableTwoFactorAuth(User $user)
    {
        if (! Authy::isEnabled($user)) {
            return redirect()->route('user.edit', $user->id)
                ->withErrors(trans('app.2fa_not_enabled_user'));
        }

        Authy::delete($user);

        $user->save();

        event(new TwoFactorDisabledByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.2fa_disabled'));
    }


    /**
     * Displays the list with all active sessions for selected user.
     *
     * @param User $user
     * @param SessionRepository $sessionRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sessions(User $user, SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('user.sessions', compact('sessions', 'user'));
    }

    /**
     * Invalidate specified session for selected user.
     *
     * @param User $user
     * @param $sessionId
     * @param SessionRepository $sessionRepository
     * @return mixed
     */
    public function invalidateSession(User $user, $sessionId, SessionRepository $sessionRepository)
    {
        $sessionRepository->invalidateUserSession($user->id, $sessionId);

        return redirect()->route('user.sessions', $user->id)
            ->withSuccess(trans('app.session_invalidated'));
    }

}