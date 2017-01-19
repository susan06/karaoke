<?php

namespace App\Repositories\Event;

use App\Event;
use Carbon\Carbon;
use App\Repositories\Repository;

class EloquentEvent extends Repository implements EventRepository
{

    public function __construct(Event $event)
    {
        parent::__construct($event);
    }

    public function index($perPage, $search = null, $status = null)
    {
        $query = Event::query();

        if ($status) {
            $query->where('status', '=', $status);
        }

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('name', "like", "%{$search}%");
                $q->orWhere('description', "like", "%{$search}%");
            });
        }

        $result = $query->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        if ($status) {
            $result->appends(['status' => $status]);
        }

        return $result;
    }

    /**
     * lists actives 
     *
     * @param string $column
     * @param string $key
     */
    public function lists_actives($column = 'name', $key = 'id')
    {
        return ['' => trans('app.select_event')] + Event::where('status', 'start')->pluck($column, $key)->all();
    }

}