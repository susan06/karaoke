<?php

namespace App\Repositories\Song;

use App\Repositories\RepositoryInterface;

interface SongRepository extends RepositoryInterface
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
     * Paginate registered songs.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function index($perPage, $search = null);

    /**
     * Search by clients.
     *
     * @param null $term
     * @return model
     */
    public function search($perPage, $search = null);

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

    /**
     *
     * add song by import csv.
     *
     * @param array $attributes
     * @return mixed
     *
     */
    public function import(array $attributes);

}