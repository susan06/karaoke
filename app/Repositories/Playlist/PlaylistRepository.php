<?php

namespace App\Repositories\Playlist;

use App\Repositories\RepositoryInterface;

interface PlaylistRepository extends RepositoryInterface
{
    /**
     * Paginate registered playlist song by user.
     *
     * @param $perPage
     * @param null $search
     * @param null $user
     */
    public function myList($perPage, $search = null, $user = null, $admin = null);

    /**
     *  ranking top 50.
     *
     * @param $perPage
     * @param null $search
     */
    public function ranking($perPage, $search = null, $branch_office = null);

    /**
     *  list song by date
     *
     * @param $perPage
     * @param null $date
     */
    public function listActuality($perPage, $date = null, $branch_office = null);

}