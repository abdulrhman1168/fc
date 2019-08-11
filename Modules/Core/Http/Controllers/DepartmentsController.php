<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\AuthOnlyController;
use Modules\Core\Entities\Core\HRDepartment;

class DepartmentsController extends AuthOnlyController
{
    /**
       * @api {get} /core/departments/main-types
       * @apiName getUserAuthorizedApps
       * @apiApp Core
       * @apiSuccess (Success 200) {JsonArray} apps list
       */
    public function mainTypes(Request $request)
    {
        $departments = HRDepartment::mainTypes()
                                   ->with('maleManager')
                                   ->get();

        return response()->json($departments);
    }
}
