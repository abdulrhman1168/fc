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


class VehicleController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $vehicles = Vehicle::get();

        return view ('transport::control.vehicle-index',compact('vehicles'));
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
            'vehicle_number'=>'required|unique:trans_vehicles',
            'plate_number'=>'required|unique:trans_vehicles',
            'chair_number'=>'required',

        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            Vehicle::create($request->all());
            return response(["تم إضافة الحافلة بنجاح",200]);
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
            'vehicle_number'=>'required|unique:trans_vehicles,vehicle_number,' . $id,
            'plate_number'=>'required|unique:trans_vehicles,plate_number,'. $id,
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            $vehicle = Vehicle::findOrFail($id) ;
            $vehicle->vehicle_number = $request->input('vehicle_number');
            $vehicle->plate_number = $request->input('plate_number');
            $vehicle->chair_number = $request->input('chair_number');
            if($vehicle->save()) {
                return new response($vehicle);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        if($vehicle->delete()) {
            return response($vehicle);
        }   
    }

    public function getVehicles(Request $request)
    {   
        $vehicles_id = Driver::where('vehicle_id','!=', $request->id)->pluck('vehicle_id')->toArray();
        $vehicles = $request->noPaginate == '1' ? Vehicle::whereNotIn('id',$vehicles_id)->get():Vehicle::orderBy('created_at', 'desc')->paginate(10);
        return Response($vehicles);
    }

}
