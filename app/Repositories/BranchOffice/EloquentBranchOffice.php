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

}