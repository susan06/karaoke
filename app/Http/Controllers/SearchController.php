<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\User;
use App\Song;
use App\Playlist;
use Illuminate\Http\Request;
use App\Http\Requests\Song\CreateSongRequest;
use App\Repositories\Song\SongRepository;
use App\Repositories\Playlist\PlaylistRepository;
use App\Repositories\BranchOffice\BranchOfficeRepository;

class SearchController extends Controller
{
     /**
     * @var SongRepository
     */
    private $songs;

    /**
     * @var PlaylistRepository
     */
    private $playlists;

     /**
     * @var BranchOfficeRepository
     */
    private $branch_offices;

    /**
     * SearchController constructor.
     * @param SongRepository $songs
     * @param PlaylistRepository $playlists
     * @param BranchOfficeRepository $branch_offices
     */
    public function __construct(SongRepository $songs, PlaylistRepository $playlists, BranchOfficeRepository $branch_offices)
    {
        $this->songs = $songs;
        $this->playlists = $playlists;
        $this->branch_offices = $branch_offices;
    }

    /**
     * Index search simple songs
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->getLogout();
        session()->put('to_reservation', 'reservations-store');
        $branch_offices = $this->branch_offices->all();
        $textSongToSearch = $request->textSongToSearch ? $request->textSongToSearch : null;

        if (count($branch_offices) > 1) {
            session()->put('branch_offices', $this->branch_offices->lists_actives());
        }

        if ($request->branch_office_id && $request->branch_office_id !== '') {
            $branch_office = $this->branch_offices->find($request->branch_office_id);
            if ($branch_office) {
                session()->put('branch_office', $branch_office);
            }
        } else {
            if (count($branch_offices) === 1) {
                session()->put('branch_office',$branch_offices->first());
            }
            session()->put('branch_office', null);
        }

        //dd(session()->get('branch_office'));

        return view('songs.search-simple', compact('branch_offices', 'textSongToSearch'));
    }

     /**
     * Search simple songs autocomplete
     *
     * @return \Illuminate\View\View
     */
    public function searchAutocomplete(Request $request)
    {
        $term = $request->q;
        $songs = $this->songs->autocomplete($term);

        return response()->json($songs); 
    }

    /**
     * Search songs by clients
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function searchByClient(Request $request)
    {
        $perPage = 10;
        $search = $request->q;
        $songs = $this->songs->search($perPage, $search);
        
        return response()->json([
            view('songs.list', compact('songs'))->render()
        ]);
    }

    /**
     * Apply for song
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applySong(Request $request)
    {
        try {
            $this->playlists->create([
                'song_id' => $request->id, 
                'nick' => $request->nick, 
                'branch_office_id' => session('branch_office')->id 
            ]);
            $song = $this->songs->find($request->id); 
            $response = [
                'success' => true,
                'status' => 'success',
                'disabled' => true,
                'message' => trans('app.apply_for_send_simple')
            ];
        } catch (Exception $e){
            $response = [
                'success' => false,
                'status' => 'error',
                'disabled' => false,
                'message' => trans('app.apply_for_send_not')
            ];
        }
            
        return response()->json($response);   
    }

    /**
     * Log the user out of the application.
     */
    public function getLogout()
    {
        if(Auth::user()) {
              Auth::logout();
        }
    }
}
