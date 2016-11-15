<?php

namespace App\Repositories\Reservation;

use App\Repositories\RepositoryInterface;

interface ReservationRepository extends RepositoryInterface
{
    /**
     *
     * Can add song by superadmin.
     *
     * @param array $attributes
     * @return mixed
     *
     */
    public function canAdd(array $attributes);

    /**
     *  list Reservation by date
     *
     * @param $perPage
     * @param null $date
     * @param null $user
     */
    public function index($perPage, $date = null, $user = null, $admin = null);


}