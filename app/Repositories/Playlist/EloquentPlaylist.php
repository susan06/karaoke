<?php

namespace App\Repositories\Playlist;

use DB;

use App\Song;
use App\Playlist;
use App\Repositories\Repository;

class EloquentPlaylist extends Repository implements PlaylistRepository
{

    public function __construct(Playlist $playlist)
    {
        parent::__construct($playlist);
    }

    /**
     * Paginate registered playlist song by user.
     *
     * @param $perPage
     * @param null $search
     * @param null $user
     * @return mixed
     */
    public function myList($perPage, $search = null, $user = null) 
    {
 		$query = Playlist::where('user_id', '=', $user)
    		->orderBy('created_at', 'DESC')
    		->groupBy('song_id')
    		->select(['*', DB::raw('count(song_id) as count')]);

        if ($search) {
        	$query->whereHas(
                'song', function ($q) use($search) {
                   $q->where('title', "like", "%{$search}%");
                   $q->orWhere('artist', 'like', "%{$search}%");
                }
            );
        } 

        $result = $query->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;
    }

    /**
     * Paginate registered ranking top 50.
     *
     * @param $perPage
     * @param null $search
     * @return mixed
     */
    public function ranking($perPage, $search = null)
    {
    	$query = Playlist::groupBy('song_id')
    		->select(['*', DB::raw('count(song_id) as count')])
    		->orderBy('count', 'DESC');

        if ($search) {
        	$query->whereHas(
                'song', function ($q) use($search) {
                   $q->where('title', "like", "%{$search}%");
                   $q->orWhere('artist', 'like', "%{$search}%");
                }
            );
        } 

        $result = $query->take(50)->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;	
    }

}