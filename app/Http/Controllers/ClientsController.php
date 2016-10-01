<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Support\Enum\UserStatus;
use App\User;
use Auth;
use App\Repositories\Session\SessionRepository;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Input;

/**
 * Class ClientsController
 * @package App\Http\Controllers
 */
class ClientsController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var ActivityRepository
     */
    private $activities;

    /**
     * ClientsController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users, ActivityRepository $activities)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        $this->users = $users;
        $this->activities = $activities;
    }

       /**
     * Display paginated list of all users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $perPage = 10;

        $users = $this->users->clientIndex($perPage, Input::get('search'), Input::get('status'));
        $statuses = ['' => trans('app.all')] + UserStatus::lists();

        return view('clients.list', compact('users', 'statuses'));
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

        return view('clients.sessions', compact('sessions', 'user'));
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

        return redirect()->route('user.client.sessions', $user->id)
            ->withSuccess(trans('app.session_invalidated'));
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

        return view('clients.view', compact('user', 'socialNetworks', 'userActivities'));
    }


    /**
     * Displays the activity log page for specific user.
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activity(User $user, Request $request)
    {
        $perPage = 10;

        $activities = $this->activities->paginateActivitiesForUser(
            $user->id, $perPage, $request->get('search')
        );

        return view('clients.activity', compact('activities', 'user'));
    }

}
