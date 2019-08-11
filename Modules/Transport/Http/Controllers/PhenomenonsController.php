<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Track;
use Modules\Transport\Entities\Phenomenon;
use Illuminate\Support\Facades\Input;



class PhenomenonsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $phenomenon =  Phenomenon::getAllData();
        return view('transport::activities.index',compact('phenomenon'));

    }



    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create()
    {
      $track = Track::all();
      return view('transport::phenomenons.create',compact('track'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $request->validate([
      'phenomenon_status'=>'required',
      'phenomenon_type'=>'required',
      'place'=>'required',
      'actualtime'=>'required',
      'dayreality'=>'required',
      'track'=>'required',
      'attachment'=>'required',
      ]);
      $allowedExtentions = ['pdf', 'jpg','png','docx','xlsx'];

    if($request->hasFile('attachment'))
    {


      $destinationPath = public_path('uploads/transport');
      $attachment = $request->file('attachment');
      $extension = $attachment->getClientOriginalExtension();
      $fileName = uniqid()  . '.'. time() . '.' .$extension;
      $attachment->move($destinationPath, $fileName);
      $request->attachment = $fileName ;
    }

    $request->user_id = \Auth::user()->user_id;
    $ph =   new Phenomenon($request->all());
    $ph->attachment = $fileName;
    $ph->save();

      return redirect('transport/phenomens')->with('success',"تم تقديم الظاهره بنجاح");


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
}
