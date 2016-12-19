<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Repositories\BranchOffice\BranchOfficeRepository;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var BranchOfficeRepository
     */
    private $branch_offices;

    public function __construct(BranchOfficeRepository $branch_offices)
    {
        $branch_offices = $this->branch_offices->all();

        if ( count($branch_offices) > 1 && !session('branch_offices')) {
            session()->put('branch_offices', $this->branch_offices->lists_actives()); 
        } 

    }
       
}
