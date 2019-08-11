<?php

namespace Modules\DepartmentServices\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Core\Entities\Core\Employee;
use Modules\Auth\Entities\Core\User;
use Modules\DepartmentServices\Entities\UpdateResearchs;

use Auth;
use Validator;
class UpdateResearch extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

      $updateResearchs = UpdateResearchs::getData();
                                   
                      
        return view('departmentservices::updateResearch.index')
                ->with('updateResearchs', $updateResearchs);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */

     public function check(Request $request, $user_id)
     {

       $validator = Validator::make($request->all(), [
         'pladge' => 'required|in:2,0'
       ]);


       // Validation
       if ($this->isApiCall) {

         if ($validator->fails()) {

             return response()->json($validator->errors(), 422);

         }
       } else {

           $validator->validate();
       }

       $updateResearch = User::find($user_id);

       if($updateResearch->pladge == 1){
         $updateResearch->pladge = $request->pladge;

         $updateResearch->save();
       }

       // Validation
       if ($this->isApiCall) {

         return response()->json($vacation, 201);

       } else {

         return redirect('/department-services/updateResearch');

       }
     }

}
