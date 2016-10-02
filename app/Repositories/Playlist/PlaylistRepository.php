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

}