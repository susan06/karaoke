<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Requests\Event\CreateEvent;
use App\Http\Requests\Event\UpdateEvent;
use App\Repositories\Event\EventRepository;
use App\Repositories\User\UserRepository;

class EventController extends Controller
{
    /**
     * @var EventRepository
     */
    private $events;

    /**
     * EventController constructor.
     * @param EventRepository $events
     */
    public function __construct(EventRepository $events)
    {
        $this->middleware('auth');
        $this->events = $events;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 10;

        $events = $this->events->index($perPage, $request->search, $request->status);
        $statuses = [
            '' => trans('app.all'),
            'start' => trans('app.start'), 
            'finish' => trans('app.finish')
        ];

        return view('events.list', compact('events', 'statuses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contests(Request $request)
    {
        $perPage = 10;
        $events = $this->events->index_client($perPage);

        return view('events.list_contests', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;

        return view('events.create-edit', compact('edit'));
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
    public function edit($id)
    {
        $edit = true;
        $event = $this->events->find($id);
        $status = [
            'start' => trans('app.start'), 
            'finish' => trans('app.finish')
        ];

        return view('events.create-edit', compact('event', 'status', 'edit'));
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
        $client = $this->events->find_client($id, $request->user_id);
        if ( !$client ) {
            $event = $this->events->add_client([
                'event_id' => $id, 
                'user_id' => $request->user_id
            ]);

            return response()->json([
                'success' => true,
                'url_return' => route('event.add.client', $id)
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'el usuario ya fue agregado al evento'
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
            'client' => "Nombre: ".$client->user->first_name." ".$client->user->last_name.", Email: ".$client->user->email.""
            ];
        }
        arsort($votes);
        
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
