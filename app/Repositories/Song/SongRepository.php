<?php

namespace App\Repositories\Song;

use App\Repositories\RepositoryInterface;

interface SongRepository extends RepositoryInterface
{
    
    /**
     * Search autocomplete.
     *
     * @param null $term
     * @return model
     */
    public function autocomplete($term = null);
}