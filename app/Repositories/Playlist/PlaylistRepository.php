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
     * @return mixed
     */
    public function myList($perPage, $search = null, $user = null);

    /**
     * Paginate registered ranking top 50.
     *
     * @param $perPage
     * @param null $search
     * @return mixed
     */
    public function ranking($perPage, $search = null);

}