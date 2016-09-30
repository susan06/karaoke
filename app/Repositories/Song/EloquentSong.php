<?php

namespace App\Repositories\Song;

use DB;

use App\Song;
use App\Repositories\Repository;

class EloquentSong extends Repository implements SongRepository
{

    public function __construct(Song $song)
    {
        parent::__construct($song);
    }


    /**
     * Search autocomplete.
     *
     * @param null $term
     * @return model
     */
    public function autocomplete($term = null)
    {

        $query = DB::table('songs')
        ->distinct()
        ->select('title', 'artist', 'id')
        ->where('title', 'LIKE', '%'.$term.'%')
        ->orWhere('artist', 'LIKE', '%'.$term.'%')
        ->take(10)
        ->get();
        
        foreach ($query as $data) {
        $return_array[] = $data->artist.' - '.$data->title;
        }

        return $return_array;
    }

  
}