<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\City;
use Modules\Transport\Entities\District;
use Modules\Transport\Entities\Track;
use Modules\Transport\Entities\Vehicle;
use Modules\Transport\Entities\Driver;
use Modules\Core\Entities\Core\HRDepartment;
use Validator;


class CityController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $cities = City::get();

        return view ('transport::control.city-index',compact('cities'));
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
        $validator = Validator::make($request->all(), [
            'name_ar'=>'required|unique:trans_city',
            'name_en'=>'required|unique:trans_city',
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            City::create($request->all());
            return response(["تم إضافة المدينة بنجاح",200]);
        }

    
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
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name_ar'=>'required|unique:trans_city,name_ar,' . $id,
            'name_en'=>'required|unique:trans_city,name_en,'. $id,
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            $city = City::findOrFail($id) ;
            $city->name_ar = $request->input('name_ar');
            $city->name_en = $request->input('name_en');
            if($city->save()) {
                return new response($city);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        if($city->delete()) {
            return response($city);
        }   
    }
    public function getCities(Request $request)
    {  
        $cities = $request->noPaginate == '1' ? City::all():City::orderBy('created_at', 'desc')->paginate(10);
        return Response($cities);
    }
}
