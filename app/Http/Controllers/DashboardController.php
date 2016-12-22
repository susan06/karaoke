<?php

namespace App\Http\Controllers;

use App\Repositories\Activity\ActivityRepository;
use App\Repositories\User\UserRepository;
use App\Support\Enum\UserStatus;
use Auth;
use Carbon\Carbon;
use App\Repositories\BranchOffice\BranchOfficeRepository;

class DashboardController extends Controller
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
     * @var BranchOfficeRepository
     */
    private $branch_offices;

    /**
     * DashboardController constructor.
     * @param UserRepository $users
     * @param ActivityRepository $activities
     * @param BranchOfficeRepository $branch_offices
     */
    public function __construct(UserRepository $users, ActivityRepository $activities, BranchOfficeRepository $branch_offices)
    {
        $this->middleware('auth');
        $this->users = $users;
        $this->activities = $activities;
        $this->branch_offices = $branch_offices;
    }

    /**
     * Displays dashboard based on user's role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $branch_offices = $this->branch_offices->all();

        if ( count($branch_offices) > 1 && !session('branch_offices')) {
            session()->put('branch_offices', $this->branch_offices->lists_actives()); 
        } 

        if (Auth::user()->hasRole('superAdmin')) {
            return $this->adminDashboard();
        }

        if (Auth::user()->hasRole('user')) {
            return redirect()->route('song.search');
        }

        if (Auth::user()->hasRole('admin')) {

            return redirect()->route('user.client.index');
        }

        if (Auth::user()->hasRole('dj')) {

            return redirect()->route('song.apply.list');
        }
    }

    /**
     * Displays dashboard for admin users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function adminDashboard()
    {
        $usersPerMonth = $this->users->countOfNewUsersPerMonth(
            Carbon::now()->startOfYear(),
            Carbon::now()
        );

        $stats = [
            'total' => $this->users->count(),
            'total_clients' => $this->users->countClients(),
            'banned' => $this->users->countByStatus(UserStatus::BANNED),
            'unconfirmed' => $this->users->countByStatus(UserStatus::UNCONFIRMED)
        ];

        $latestRegistrations = $this->users->latest(7);

        return view('dashboard.admin', compact('stats', 'latestRegistrations', 'usersPerMonth'));
    }

}