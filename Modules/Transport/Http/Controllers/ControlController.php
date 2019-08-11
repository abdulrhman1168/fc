<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use Modules\Transport\Entities\City;
use Modules\Transport\Entities\District;
use Modules\Transport\Entities\Track;
use Modules\Transport\Entities\Vehicle;
use Modules\Transport\Entities\Driver;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Transport\Entities\Setting;
use Modules\Core\Entities\SchoolYear;

class ControlController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $cities = City::get();
        $vehciles = Vehicle::get();
        $college = HRDepartment::where('type','=','2')->get();
        $districts = District::districts();
        $track = Track::tracks();
        $drivers = Driver::drivers();
        return view('transport::control.index',compact('cities','districts','college','track','drivers','vehciles'));
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function createCity()
    {
        return view('transport::control.create-city');
    }

    public function createDistrict()
    {
      $cities = City::all();
      return view('transport::control.create-district',compact('cities'));
    }

    public function createTrack()

    {
      $cities = City::all();
      $college = HRDepartment::where('type','=','2')->get();
      $districts = District::with('cityObject')->get();
      return view('transport::control.create-track',compact('cities','college','districts'));

    }

    public function createDriver()

    {
      $cities = City::all();
      $college = HRDepartment::where('type','=','2')->get();
      $districts = District::with('cityObject')->get();
      $track = Track::all();
      return view('transport::control.create-driver',compact('cities','college','districts','track'));

    }



    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      if($request->input('city_s')!=NULL)
      {
        $request->validate([
          'name_ar'=>'required|unique:trans_city',
          'name_en'=>'required|unique:trans_city',
        ]);
        City::create($request->all());
       return response("تم إضافة المدينة بنجاح",200);
      }

      elseif($request->input('district_s')!=NULL)
      {
        $request->validate([
          'city'=>'required',
          'name_ar'=>'required|unique:trans_district',
          'name_en'=>'required|unique:trans_district',
        ]);
        District::create($request->all());
        return response("تم إضافة الحي بنجاح",200);
      }
      elseif ($request->input('track_s')!=NULL)
      {
        $request->validate([
          'city'=>'required',
          'district'=>'required',
          'college'=>'required',

        ]);
        Track::create($request->all());
        return response("تم إضافة المسار بنجاح",200);


      }
      elseif($request->input('vehicle_s') != NULL)
      {
          $request->validate([
            'vehicle_number'=>'required|unique:trans_vehicles',
            'plate_number'=>'required|unique:trans_vehicles',
          ]);
          Vehicle::create($request->all());
         return response("تم إضافة الحافلة بنجاح",200);

      }
      elseif($request->input('driver')!=NULL)
      {
        $request->validate([
          'name'=>'required',
          'mobile'=>'required',
          'vehicle_id'=>'required',
          'companion'=>'required',
          'companion_no'=>'required',
          'track'=>'required',
        ]);



        Driver::create($request->all());
        return response("تم إضافة السائق بنجاح",200);
;



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
    public function edit(Request $request)
    {
      if($request->input('city_s_1')!=NULL)
      {
      $id = $request->input('id');
      $city = City::find($id);
      $city->name_ar = $request->input('name_ar');
      $city->name_en = $request->input('name_en');
      $city->save();
      return back()->with('success', "تم التحديث بنجاح");

    }

    elseif($request->input('district_s_1')!=NULL)
    {
    $id = $request->input('id');
    $district = District::find($id);
    $district->city = $request->input('city');
    $district->name_ar = $request->input('name_ar');
    $district->name_en = $request->input('name_en');
    $district->save();
    return back()->with('success', "تم التحديث بنجاح");


    }
    elseif($request->input('track_s1')!=NULL)
    {
    $id = $request->input('id');
    $track = Track::find($id);
    $track->city = $request->input('city');
    $track->district = $request->input('district');
    $track->college = $request->input('college');
    $track->save();
    return back()->with('success', "تم التحديث بنجاح");


    }
    elseif($request->input('drivers_1')!=NULL)
    {
    $id = $request->input('id');
    $driver = Driver::find($id);
    $driver->name = $request->input('name');
    $driver->mobile = $request->input('mobile');
    $driver->bus_no = $request->input('bus_no');
    $driver->plate_no = $request->input('plate_no');
    $driver->companion = $request->input('companion');
    $driver->companion_no = $request->input('companion_no');
    $driver->track = $request->input('track');
    $driver->save();
    return back()->with('success', "تم التحديث بنجاح");


    }


  }

  public function getDistrictsOfCity(Request $request)
  {
    $districts = District::where('city',$request->city_id)->get();
    return Response()->json([
      'districts' => $districts
    ]);
  }

  public function getColleges()
  {
    $colleges = HRDepartment::where('type','=','2')->get();
    return Response()->json([
      'colleges' => $colleges
    ]);
  }

  public function getTracks()
  {
    $tracks = Track::leftjoin('trans_city','trans_city.id','trans_track.city')
        ->leftjoin('trans_district','trans_district.id','trans_track.district')
        ->leftjoin('hr_departments','hr_departments.id','trans_track.college')
        ->select('trans_track.*','trans_city.name_ar as city_name_ar','trans_district.name_ar as district_name_ar','hr_departments.name as college_name_ar')
        ->get();
    return Response()->json([
      'tracks' => $tracks
    ]);
  }
  
  public function getVehicles()
  {
    $vehicles = Vehicle::get();
    return Response()->json([
      'vehicles' => $vehicles
    ]);
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

    public function CityIndex()
    {
      $cities = City::get();

      return view ('transport::control.city-index',compact('cities'));
    }

    public function controlGate(Request $request) {

      if ($request->wantsJson() || $request->ajax()) {

        $dailyReports = Setting::select(['id', 'start_date', 'end_date','year']);

        return Datatables::of($dailyReports)
         
           ->toJson();

    } else {
      return view('transport::control.control-gate');
    }
     
    }

    public function addRegistrationPeriod() {

      $schoolYears = SchoolYear::pluck('name', 'id')->toArray();
      
      return view('transport::control.add-registration-period')
      ->withSchoolYears($schoolYears);
    }

     public function saveRegistrationPeriod(Request $request)
    {
      

    $request->validate([
      'start_date' => 'required',
        'end_date' => 'required',
        'year' => 'required',
     ]);

     Setting::create($request->all());
     session()->flash('success_alert', __('salekclub::app.trainer_added'));
     return redirect()->route('trans.controlGate');

    }


}
