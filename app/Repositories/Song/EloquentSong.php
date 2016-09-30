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
     * Paginate registered songs.
     *
     */
    public function index($perPage, $search = null)
    {
        $query = Song::query();

        if ($search) {
            $find   = ' - ';
            $pos = strpos($search, $find);

            if($pos) {
                $string = explode($find, $search);
                $query->where('artist', "like", "%{$string[0]}%");
                $query->where('title', 'like', "%{$string[1]}%");
            } else {
                $query->where(function ($q) use($search) {
                    $q->where('title', "like", "%{$search}%");
                    $q->orWhere('artist', 'like', "%{$search}%");
                });
            }
        }

        $result = $query->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;
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
        ->select('title', 'artist')
        ->where('title', 'LIKE', '%'.$term.'%')
        ->orWhere('artist', 'LIKE', '%'.$term.'%')
        ->take(10)
        ->get();
        
        foreach ($query as $data) {
        $return_array[] = $data->artist.' - '.$data->title;
        }

        return $return_array;
    }

    /**
     * Search autocomplete by client.
     *
     * @param null $term
     * @return model
     */
    public function autocompleteArtist($term = null)
    {

        $query = DB::table('songs')
        ->distinct()
        ->select('artist')
        ->orWhere('artist', 'LIKE', '%'.$term.'%')
        ->take(10)
        ->get();
        
        foreach ($query as $data) {
        $return_array[] = $data->artist;
        }

        return $return_array;
    }

  
}