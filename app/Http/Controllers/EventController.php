<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Requests\Event\CreateEvent;
use App\Http\Requests\Event\UpdateEvent;
use App\Repositories\Event\EventRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\BranchOffice\BranchOfficeRepository;

class EventController extends Controller
{
    /**
     * @var EventRepository
     */
    private $events;

     /**
     * @var BranchOfficeRepository
     */
    private $branch_offices;

    /**
     * EventController constructor.
     * @param EventRepository $events
     */
    public function __construct(
        EventRepository $events,
        BranchOfficeRepository $branch_offices
    ){
        $this->middleware('auth');
        $this->events = $events;
        $this->branch_offices = $branch_offices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BranchOfficeRepository $branch_offices)
    {
        $perPage = 10;
        $branch_offices = ['' => trans('app.select_a_branch_office')] + $branch_offices->lists_actives();
        $events = $this->events->index($perPage, $request->search, $request->status, $request->branch_office_id);
        $statuses = [
            '' => trans('app.all'),
            'start' => trans('app.start'), 
            'finish' => trans('app.finish')
        ];

        return view('events.list', compact('events', 'statuses', 'branch_offices'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contests(Request $request)
    {
        $perPage = 10;
        $branch_offices = $this->branch_offices->all();
        $branch_office = $branch_offices->first();

        if ($request->branch_office_id) {
            $branch_office = $this->branch_offices->find($request->branch_office_id);
            session()->put('branch_office', $branch_office); 
        }

        if ( count($branch_offices) > 1) {
            session()->put('branch_offices', $this->branch_offices->lists_actives()); 
        } else {
            if(!session('branch_office')) {
                session()->put('branch_office', $branch_office); 
            } 
        }
        $events = $this->events->index_client($perPage);

        return view('events.list_contests', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BranchOfficeRepository $branch_offices)
    {
        $edit = false;
        $branch_offices = $branch_offices->lists_actives();

        return view('events.create-edit', compact('edit', 'branch_offices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEvent $request)
    {
        $event = $this->events->create($request->all());

        if ( $event ) {

            return redirect()->route('event.index')
            ->withSuccess(trans('app.event_created'));
        } else {
            
            return back()->withError(trans('app.error_again'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, BranchOfficeRepository $branch_offices)
    {
        $edit = true;
        $event = $this->events->find($id);
        $branch_offices = $branch_offices->lists_actives();
        $status = [
            'start' => trans('app.start'), 
            'finish' => trans('app.finish')
        ];

        return view('events.create-edit', compact('event', 'status', 'edit', 'branch_offices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEvent $request, $id)
    {
        $event = $this->events->update(
            $id, 
            $request->all()
        );

        if ( $event ) {

            return redirect()->route('event.index')
            ->withSuccess(trans('app.event_updated'));
        } else {
            
            return back()->withError(trans('app.error_again'));
        }
    }

    /**
     * Removes the user from database.
     *
     * @param Request $request
     * @return $this
     */
    public function delete(Request $request)
    {
        $destroy = $this->events->delete($request->id);

        return response()->json(['success'=> true]);

    }

    /**
     * form and list of clients of events
     *
     */
    public function add_client($id, UserRepository $userRepository)
    {
        $event = $this->events->find($id);
        
        return view('events.add_clients', compact('event'));
    }

    /**
     * store client of event
     *
     */
    public function storeClient($id, Request $request)
    {
        $client = $this->events->find_client($id, $request->participant);
        if ( !$client ) {
            $event = $this->events->add_client([
                'event_id' => $id, 
                'participant' => $request->participant
            ]);

            return response()->json([
                'success' => true,
                'url_return' => route('event.add.client', $id)
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'el participante ya fue agregado al evento'
            ]);
        }
    }

     /**
     * Delete participant
     *
     */
    public function delete_participant(Request $request)
    {
        $destroy = $this->events->delete_participant($request->id);

        return response()->json(['success'=> true]);

    }

    /**
     * store client of event
     *
     */
    public function show_votes($id, Request $request)
    {
        $event = $this->events->find($id);
        $votes = array();

        foreach ($event->event_clients as $client) {
            $votes[] = [
            'count' => $client->vote_clients->count(),
            'participant' => $client->participant
            ];
        }
        arsort($votes);

        if ( $request->ajax() ) {
            return response()->json([
                'success' => true,
                'view' => view('events.list_votes', compact('votes'))->render(),
            ]);
        }
        
        return view('events.client_votes', compact('event', 'votes'));
    }

    /**
     * show participants of event
     *
     */
    public function show_participants($id, Request $request)
    {
        $event = $this->events->find($id);
        
        return view('events.list_participants', compact('event'));
    }

    /**
     * vote by participant
     *
     */
    public function vote_participant(Request $request) 
    {
        $isVote = $this->events->find_vote($request->event_id, Auth::user()->id);
        if ( !$isVote ) {
            $event = $this->events->add_vote([
                'user_id' => Auth::user()->id, 
                'event_id' => $request->event_id,
                'event_client_id' => $request->event_client_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Se ha registrado su voto con éxito. Solo tiene permitido votar una vez',
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Ya usted a votado por un participante del concurso'
            ]);
        }
    }

}
