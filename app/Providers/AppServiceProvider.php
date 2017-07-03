<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Activity\EloquentActivity;
use App\Repositories\Role\EloquentRole;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Session\DbSession;
use App\Repositories\Session\SessionRepository;
use App\Repositories\User\EloquentUser;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Song\EloquentSong;
use App\Repositories\Song\SongRepository;
use App\Repositories\Playlist\EloquentPlaylist;
use App\Repositories\Playlist\PlaylistRepository;
use App\Repositories\Reservation\EloquentReservation;
use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\BranchOffice\EloquentBranchOffice;
use App\Repositories\BranchOffice\BranchOfficeRepository;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EloquentEvent;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Coupon\EloquentCoupon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, EloquentUser::class);
        $this->app->singleton(ActivityRepository::class, EloquentActivity::class);
        $this->app->singleton(RoleRepository::class, EloquentRole::class);
        $this->app->singleton(SessionRepository::class, DbSession::class);
        $this->app->singleton(SongRepository::class, EloquentSong::class);
        $this->app->singleton(PlaylistRepository::class, EloquentPlaylist::class);
        $this->app->singleton(ReservationRepository::class, EloquentReservation::class);
        $this->app->singleton(BranchOfficeRepository::class, EloquentBranchOffice::class);
        $this->app->singleton(EventRepository::class, EloquentEvent::class);
        $this->app->singleton(CouponRepository::class, EloquentCoupon::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
