<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\District;
use Modules\Transport\Entities\Track;
use Modules\Transport\Entities\Vehicle;
use Modules\Transport\Entities\Driver;
use Modules\Core\Entities\Core\HRDepartment;
use Validator;


class TrackController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view ('transport::control.track-index');
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
            'track_number' => 'required',
            'city_id'=>'required',
            'district_id'=>'required',
            'college_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            Track::create($request->all());
            return response(["تم إضافة المسار بنجاح",200]);
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
            
            'track_number' => 'required'.$id,
            'city_id'=>'required',
            'district_id'=>'required',
            'college_id' => 'required'

        ]);
            
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            $track = Track::findOrFail($id) ;
            $track->city_id = $request->input('city_id');
            $track->district_id = $request->input('district_id');
            $track->college_id = $request->input('college_id');
            $track->track_number = $request->input('track_number');
            if($track->save()) {
                return new response($track);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $track = Track::findOrFail($id);
        if($track->delete()) {
            return response($track);
        }   
    }


    public function getTracks(Request $request)
    {  
        $tracks = $request->noPaginate == '1' ? Track::tracks(1):Track::tracks(0);
        return Response($tracks);
    }

    public function getColleges(Request $request)
    {  
        $colleges = $request->noPaginate == '1' ? HRDepartment::where('type','=','2')->orWhere('id',5914)->get():HRDepartment::where('type','=','2')->orderBy('created_at', 'asc')->paginate(10);
        return Response($colleges);
    }

    public function getDistrictsOfCity($id)
    {
        $districts = District::where('city_id',$id)->get();
        return Response($districts);
    }

}
