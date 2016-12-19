<?php

namespace App\Repositories\Playlist;

use DB;
use Carbon\Carbon;

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
    public function myList($perPage, $search = null, $user = null, $admin = null) 
    {
 		$query = Playlist::where('user_id', '=', $user)
            ->where('branch_office_id', '=', session('branch_office')->id)
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

        if ($admin) {
            $result->appends(['user' => $user]);
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
    public function ranking($perPage, $search = null, $branch_office = null)
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

        if ($branch_office) {
            $query->where('branch_office_id', '=', $branch_office);
        } 

        $result = $query->take(50)->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        if ($branch_office) {
            $result->appends(['branch_office_id' => $branch_office]);
        }

        return $result;	
    }

    /**
     *  list song by date
     *
     * @param $perPage
     * @param null $date
     */
    public function listActuality($perPage, $date = null, $branch_office = null, $dj = null)
    {
    	$today = Carbon::today()->toDateString().'%';

        if ($date) {
        	$date1 = date_format(date_create($date), 'Y-m-d');
        	$query = Playlist::where('created_at', 'like', $date1.'%')->orderBy('created_at', 'asc');
        } else {
        	$query = Playlist::where('created_at', 'like', $today.'%')->orderBy('created_at', 'asc');
        }

        if ($dj && session('branch_office')) {
            $query->where('branch_office_id', '=', session('branch_office')->id);
        } 

        if ($branch_office) {
            $query->where('branch_office_id', '=', $branch_office);
        } 

        $result = $query->paginate($perPage);

        if ($date) {
            $result->appends(['date' => $date]);
        }

        if ($branch_office) {
            $result->appends(['branch_office_id' => $branch_office]);
        }

        return $result;
    }

}