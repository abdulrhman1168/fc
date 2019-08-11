<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Driver;
use Modules\Transport\Entities\Track;
use Modules\Transport\Entities\Vehicle;
use Modules\Transport\Entities\District;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Transport\Entities\DriverTrack;
use Modules\Transport\Entities\DailyMovement;
use Modules\Transport\Entities\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use App\Classes\Date\CarbonHijri;
use Carbon\Carbon;
use Validator;


class DriverController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view ('transport::control.driver-index');
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
            'name'=>'required|unique:trans_driver',
            'mobile'=>'required|phone_number|unique:trans_driver',
            'companion'=>'required|unique:trans_driver',
            'companion_no'=>'required|phone_number|unique:trans_driver',
            'track' => 'required',
            'vehicle_id' => 'required'

        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],402);
        }
        else
        {
            $driver = Driver::create($request->all());
            foreach($request->track as $track)
            {
                DriverTrack::create([
                    'track_id' =>$track['track_id'],
                    'driver_id' => $driver->id
                ]);
            }
            return response(["تم إضافة السائق بنجاح",200,$driver->id]);
        }

    
    }

    public function uploadDriverFiles(Request $request, $driver_id)
    {
        foreach ($request->file('files') as $key => $file) {
            $imageName = time().'.'. $file->getClientOriginalExtension();
            $file->move(public_path('files/drivers/'.$driver_id), $imageName);
            $file = File::create([
                'path' => '/files/drivers/'.$driver_id .'/'.$imageName,
                'original_name' => $file->getClientOriginalName(),
                'model_id' => $driver_id,
                'model' => 'Driver',
            ]);
        }
        return response(["تم إضافة السائق بنجاح",200]);
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
            'name'=>'required|unique:trans_driver,name,'. $id,
            'mobile'=>'required|phone_number|unique:trans_driver,mobile,'. $id,
            'companion'=>'required|unique:trans_driver,companion,'. $id,
            'companion_no'=>'required|phone_number|unique:trans_driver,companion_no,'. $id,
            'track' => 'required',
            'vehicle_id' => 'required'
        ]);
            
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            
            $driver = Driver::findOrFail($id);
            $driver->update($request->all());
            DriverTrack::where('driver_id',$driver->id)->delete(); //sync
            foreach($request->track as $track)
            {
                DriverTrack::create([
                    'track_id' =>$track['track_id'],
                    'driver_id' => $driver->id
                ]);
            }
            if($driver){
                return new response([$driver->id,200]);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $files = File::where('model_id',$driver->id)->get();
        \File::deleteDirectory(public_path('files/drivers/'.$driver->id));
        foreach ($files as $key => $file) {
            $driver->delete();
            $file->delete();
        }
        DriverTrack::where('driver_id',$driver->id)->delete(); //sync
            return response($driver);
      
    }


    public function getDrivers(Request $request)
    {
        if($request->noPaginate == '1')
        {
            $drivers =  Driver::drivers(1);
            return Response($drivers);
        }
        else
        {
            $date = CarbonHijri::toHijriFromMiladi(Carbon::now());
            $drivers = Driver::drivers(0);
            $result = Driver::getTracksDriver($drivers->get());
            $drivers =  Driver::drivers(0)->with('Files')->paginate(10);
            return Response(['drivers'=> $drivers,'tracks'=>$result[0],'attendace_exist'=>$result[1],'DailyMovement_m_exist' => $result[2],'DailyMovement_e_exist' => $result[3],'date'=>$date]);
        }
    }

}
