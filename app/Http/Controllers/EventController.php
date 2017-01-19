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

    public function create_client($id, UserRepository $userRepository)
    {
        $list_clients = $userRepository->list_client();
        $event = $this->events->find($id);
        
        return view('events.add_clients', compact('list_clients', 'event'));
    }

    public function storeClient($id, Request $request)
    {
        $event = $this->events->add_client($id, $request->get('user_id'));

        if ( $event ) {

            return redirect()->route('event.add.client', $id)
            ->withSuccess(trans('app.added_client'));
        } else {
            
            return back()->withError(trans('app.error_again'));
        }
    }
}
