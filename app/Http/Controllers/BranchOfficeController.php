<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BranchOffice\CreateBranchOffice;
use App\Repositories\BranchOffice\BranchOfficeRepository;

class BranchOfficeController extends Controller
{
    /**
     * @var BranchOfficeRepository
     */
    private $branch_offices;

    /**
     * BranchOfficeController constructor.
     * @param BranchOfficeRepository $branch_offices
     */
    public function __construct(BranchOfficeRepository $branch_offices)
    {
        $this->middleware('auth');
        $this->branch_offices = $branch_offices;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 10;

        $branch_offices = $this->branch_offices->index($perPage, $request->search, $request->status);
        $statuses = [
            '' => trans('app.all'),
            true  => trans('app.published'), 
            false  => trans('app.nopublished')
        ];

        return view('branchoffices.list', compact('branch_offices', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;

        return view('branchoffices.create-edit', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBranchOffice $request)
    {
        $branch_office = $this->branch_offices->create($request->all());

        if ( $branch_office ) {

            return redirect()->route('branch-office.index')
            ->withSuccess(trans('app.branch_office_created'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
