<?php

namespace App\Repositories\Event;

use App\Event;
use App\Repositories\RepositoryInterface;

interface EventRepository extends RepositoryInterface
{
    
    /**
     * Paginate registered users.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function index($perPage, $search = null, $status = null);

    /**
     * lists actives 
     *
     * @param string $column
     * @param string $key
     */
    public function lists_actives($column = 'name', $key = 'id');

     /**
     * find client of event
     *
     * @param int $event_id
     * @param int $client_id
     */
    public function find_client($event_id, $client_id);

     /**
     * add client of event
     *
     * @param array $data
     */
    public function add_client(array $data);

     /**
     * list event for client
     *
     */
    public function index_client($perPage);

    /**
     * find vote of user
     *
     * @param int $event_id
     * @param int $user_id
     */
    public function find_vote($event_id, $user_id);

     /**
     * add client of event
     *
     * @param array $data
     */
    public function add_vote(array $data);

}