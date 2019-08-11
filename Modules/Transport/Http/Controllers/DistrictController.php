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


class DistrictController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view ('transport::control.district-index');
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
            'name_ar'=>'required|unique:trans_district',
            'city_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            District::create($request->all());
            return response(["تم إضافة الحي بنجاح",200]);
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
            
            'name_ar'=>'required|unique:trans_district,name_ar,' . $id,
            'city_id' => 'required'

        ]);
            
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            
            $district = District::findOrFail($id) ;
            $district->name_ar = $request->input('name_ar');
            $district->name_en = $request->input('name_en');
            $district->city_id = $request->input('city_id');
            if($district->save()) {
                return new response($district);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $district = District::findOrFail($id);
        if($district->delete()) {
            return response($district);
        }   
    }

    public function getDistricts(Request $request)
    {  
        if($request->noPaginate == '1')
        {
            if($request->city_id != null )
            {
                $districts = District::where('city_id',$request->city_id)->get();
            }
            else
            {
                $districts = District::all();
            }
        }
        else
        {
            $districts = District::leftJoin('trans_city','trans_city.id','trans_district.city_id')
            ->orderBy('trans_district.created_at', 'asc')
            ->select('trans_district.*','trans_city.name_ar as city_name_ar','trans_city.name_en as city_name_en')
            ->paginate(10);
        }

        return Response($districts);
    }

}
