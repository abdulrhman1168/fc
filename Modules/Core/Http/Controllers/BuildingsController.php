<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\MuBuilding;
use Modules\Core\Entities\TrCities;
use App\Http\Controllers\UserBaseController;
use Auth;
use Validator;

class BuildingsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $buildings = MuBuilding::all();
        $cities = TrCities::all();
        return view('core::building.index',compact('buildings','cities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'id_city' => 'required|numeric|min:1|max:6',
            'name' => 'required',
            'name_en' => 'required',
          ])->validate();
          
        $data['id_city'] = $request->input('id_city');
        $data['name'] = $request->input('name');
        $data['name_en'] = $request->input('name_en');
        MuBuilding::create($data);
        return redirect('/core/buildings')->with('success', 'تمت إضافة المبنى بنجاح ');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('core::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('core::edit');
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
