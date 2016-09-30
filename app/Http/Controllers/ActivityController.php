<?php

namespace App\Http\Controllers;

use App\Repositories\Activity\ActivityRepository;
use App\User;
use Illuminate\Http\Request;

/**
 * Class ActivityController
 * @package App\Http\Controllers
 */
class ActivityController extends Controller
{
    /**
     * @var EloquentActivity
     */
    private $activities;

    /**
     * ActivityController constructor.
     * @param ActivityRepository $activities
     */
    public function __construct(ActivityRepository $activities)
    {
        $this->middleware('auth');
        $this->middleware('role:superAdmin');
        $this->activities = $activities;
    }

    /**
     * Displays the page with activities for all system users.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $adminView = true;

        $activities = $this->activities->paginateActivities($perPage, $request->get('search'));

        return view('activity.index', compact('activities', 'adminView'));
    }

    /**
     * Displays the activity log page for specific user.
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userActivity(User $user, Request $request)
    {
        $perPage = 10;
        $adminView = true;

        $activities = $this->activities->paginateActivitiesForUser(
            $user->id, $perPage, $request->get('search')
        );

        return view('activity.index', compact('activities', 'user', 'adminView'));
    }
}
