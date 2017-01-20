<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
     * store client of event
     *
     */
    public function show_votes($id, Request $request)
    {
        $event = $this->events->find($id);
        $votes = array();

        foreach ($event->event_clients as $client) {
            $votes[$client->vote_clients->count()] = 'Nombre: <strong>'.$client->user->first_name.' '.$client->user->last_name.'</strong>, Email: <strong>'.$client->user->email.'</strong>, Usuario: <strong>'.$client->user->username.'</strong>';
        }
        
        return view('events.client_votes', compact('event', 'votes'));
    }

}
