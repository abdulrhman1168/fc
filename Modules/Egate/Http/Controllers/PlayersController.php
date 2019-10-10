<?php

namespace Modules\Egate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Egate\Entities\Player;
use Yajra\Datatables\Datatables;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
     
        if ($request->wantsJson() || $request->ajax()) {
            $users = Player::select('*');

            return Datatables::of($users)
               ->addColumn('action', function ($user) {
                   return '
                  

                    ';
               })
               ->make(true);
        } else {
            return view('egate::players.index');
        }

       
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

        
        return view('egate::players.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        dd('save');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('egate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('egate::edit');
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
}
