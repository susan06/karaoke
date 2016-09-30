<?php

namespace App\Repositories\Song;

use App\Repositories\RepositoryInterface;

interface SongRepository extends RepositoryInterface
{
    
     /**
     * Paginate registered songs.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function index($perPage, $search = null);

    /**
     * Search autocomplete.
     *
     * @param null $term
     * @return model
     */
    public function autocomplete($term = null);

    /**
     * Search autocomplete by artist.
     *
     * @param null $term
     * @return model
     */
    public function autocompleteArtist($term = null);
}