<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\DailyMovement;


class DailyMovementController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('transport::dailymovement.dailymovement-index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('transport::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('transport::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('transport::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function getAllDailyMovment()
    {
        $dailymovement  = DailyMovement::getAllRecords();
        return response($dailymovement);
    }

    public function getAllDailyMovmentCollegeReport($id,$date,$type)
    {
        $dailymovementReports = DailyMovement::getAllDailyMovmentColleges($id,$date,$type);
        return $dailymovementReports;
    }

    public function storeGuidence(Request $request)
    {
        $reports = DailyMovement::updateGuidence($request->all());
        return response($reports);
    }
}
