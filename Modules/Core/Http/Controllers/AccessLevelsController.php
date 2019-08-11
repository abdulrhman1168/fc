<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Entities\Core\Permission;
use Yajra\Datatables\Datatables;

class AccessLevelsController extends UserBaseController
{
    /**
     * Display a listing of the apps.
     * @return Response
     */
    public function index(Request $request)
    {
       $accessLevels = [];

       foreach (Permission::accessLevels() as $level => $name) {
         $accessLevels[] = ['id' => $level , 'name' => $name];
       }

       return $accessLevels;

    }
}
