<?php

namespace App\Repositories\Song;

use DB;
use Carbon\Carbon;
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
            $result->appends(['q' => $search]);
        }

        return $result;
    }

    /**
     * Search by clients.
     *
     * @param null $term
     * @return model
     */
    public function search($perPage, $search = null) 
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
            $result->appends(['q' => $search]);
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
        $find   = ' - ';
        $pos = strpos($term, $find);
        $return_array  = array();
        if ($pos) {
            $string = explode($find, $term);
            $query = DB::table('songs')
            ->distinct()
            ->select('title', 'artist')
            ->where('artist', "like", "%{$string[0]}%")
            ->orWhere('title', 'like', "%{$string[1]}%")
            ->take(10)
            ->get();
        } else {
             $query = DB::table('songs')
            ->distinct()
            ->select('title', 'artist')
            ->where('title', 'LIKE', '%'.$term.'%')
            ->orWhere('artist', 'LIKE', '%'.$term.'%')
            ->take(10)
            ->get();
        }  
        
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

    /**
     *
     * Can add song by superadmin.
     *
     * @param string title
     * @return array
     *
     */
     public function canAdd(array $attributes)
    {
        $artist = $attributes['artist'];
        $title = $attributes['title'];
        $songs = Song::where('artist','=',$artist)->get();
        foreach ($songs as $song) {
            if (strtolower($song->title) == strtolower($title)) {

                return ['success' => false, 'song' => $song];
            }
        }

        return ['success' => true];
    }

    /**
     *
     * add song by import csv.
     *
     * @param array $attributes
     * @return mixed
     *
     */
    public function import(array $attributes)
    {
        $artist = $attributes['artist'];
        $title = $attributes['title'];
        $songs = Song::where('artist','=',$artist)->get();
        $save = true;
        foreach ($songs as $song) {
            if ($song->title == $title) {
                $save = false;
            }
        }
        if ($save) {
            $this->model->create($attributes);
        } 
    }

    /**
     * Paginate news songs.
     *
     */
    public function news($perPage)
    {
        $query = Song::query();
        $query->whereYear('created_at', '=', Carbon::today()->year);
        $query->whereMonth('created_at', '=', Carbon::today()->month);

        $result = $query->paginate($perPage);

        return $result;
    }

}