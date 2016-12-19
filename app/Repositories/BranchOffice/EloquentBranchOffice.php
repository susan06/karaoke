<?php

namespace App\Repositories\BranchOffice;


use App\BranchOffice;
use Carbon\Carbon;
use App\Repositories\Repository;

class EloquentBranchOffice extends Repository implements BranchOfficeRepository
{

    public function __construct(BranchOffice $office)
    {
        parent::__construct($office);
    }

    public function index($perPage, $search = null, $status = null)
    {
        $query = BranchOffice::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('name', "like", "%{$search}%");
            });
        }

        $result = $query->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
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
        return ['' => trans('app.select_a_branch_office')] + BranchOffice::where('status', 1)->pluck($column, $key)->all();
    }

}