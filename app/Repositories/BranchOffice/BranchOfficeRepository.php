<?php

namespace App\Repositories\BranchOffice;

use App\BranchOffice;
use App\Repositories\RepositoryInterface;

interface BranchOfficeRepository extends RepositoryInterface
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

}