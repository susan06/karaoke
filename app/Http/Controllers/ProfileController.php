<?php

namespace App\Http\Controllers;

use App\Events\User\ChangedAvatar;
use App\Events\User\TwoFactorDisabled;
use App\Events\User\TwoFactorEnabled;
use App\Events\User\UpdatedProfileDetails;
use App\Http\Requests\User\EnableTwoFactorRequest;
use App\Http\Requests\User\UpdateProfileDetailsRequest;
use App\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Session\SessionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Upload\UserAvatarManager;
use App\Support\Enum\UserStatus;
use App\User;
use Auth;
use Authy;
use Illuminate\Http\Request;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * @var User
     */
    protected $theUser;
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);

        $this->users = $users;
        $this->theUser = Auth::user();
    }

    /**
     * Display user's profile page.
     *
     * @param RoleRepository $rolesRepo
     * @param ActivityRepository $activities
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(RoleRepository $rolesRepo, ActivityRepository $activities)
    {
        $user = $this->theUser;
        $edit = true;
        $roles = $rolesRepo->lists();
        $statuses = UserStatus::lists();
        $userActivities = $activities->getLatestActivitiesForUser($this->theUser->id, 10);
        $socialNetworks = $this->users->find($this->theUser->id)->socialNetworks;

        return view('user/profile',
            compact('user', 'edit', 'roles','statuses', 'userActivities'));
    }

    /**
     * Update profile details.
     *
     * @param UpdateProfileDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(UpdateProfileDetailsRequest $request)
    {
        $this->users->update($this->theUser->id, $request->except('role', 'status'));

        event(new UpdatedProfileDetails);

        return redirect()->back()
            ->withSuccess(trans('app.profile_updated_successfully'));
    }

    /**
     * Upload and update user's avatar.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatar(Request $request, UserAvatarManager $avatarManager)
    {
        $name = $avatarManager->uploadAndCropAvatar($this->theUser);

        return $this->handleAvatarUpdate($name);
    }

    /**
     * Update avatar for currently logged in user
     * and fire appropriate event.
     *
     * @param $avatar
     * @return mixed
     */
    private function handleAvatarUpdate($avatar)
    {
        $this->users->update($this->theUser->id, ['avatar' => $avatar]);

        event(new ChangedAvatar);

        return redirect()->route('profile')
            ->withSuccess(trans('app.avatar_changed'));
    }

    /**
     * Update user's avatar from external location/url.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatarExternal(Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded($this->theUser);

        return $this->handleAvatarUpdate($request->get('url'));
    }

    /**
     * Update user's login details.
     *
     * @param UpdateProfileLoginDetailsRequest $request
     * @return mixed
     */
    public function updateLoginDetails(UpdateProfileLoginDetailsRequest $request)
    {
        $data = $request->except('role', 'status');

        // If password is not provided, then we will
        // just remove it from $data array and do not change it
        if (trim($data['password']) == '') {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->users->update($this->theUser->id, $data);

        return redirect()->route('profile')
            ->withSuccess(trans('app.login_updated'));
    }

    /**
     * Display user activity log.
     *
     * @param ActivityRepository $activitiesRepo
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activity(ActivityRepository $activitiesRepo, Request $request)
    {
        $perPage = 20;
        $user = $this->theUser;

        $activities = $activitiesRepo->paginateActivitiesForUser(
            $this->theUser->id, $perPage, $request->get('search')
        );

        return view('activity.index', compact('activities', 'user'));
    }


    /**
     * Display active sessions for current user.
     *
     * @param SessionRepository $sessionRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sessions(SessionRepository $sessionRepository)
    {
        $profile = true;
        $user = $this->theUser;
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('user.sessions', compact('sessions', 'user', 'profile'));
    }

    /**
     * Invalidate user's session.
     *
     * @param $sessionId
     * @param SessionRepository $sessionRepository
     * @return mixed
     */
    public function invalidateSession($sessionId, SessionRepository $sessionRepository)
    {
        $sessionRepository->invalidateUserSession(
            $this->theUser->id,
            $sessionId
        );

        return redirect()->route('profile.sessions')
            ->withSuccess(trans('app.session_invalidated'));
    }
}