<?php

namespace Modules\DepartmentServices\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\DepartmentServices\Entities\Authorization\AuthorizationEmployee;
use Modules\Auth\Entities\Core\User;
use Modules\Core\Entities\Core\Permission;

class AuthorizationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a New job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Active New authorizations
        $newAuthorizations = AuthorizationEmployee::where([
            ['from_date', '<=', date('Y-m-d')],
            ['auth_status', 0]
        ])
        ->with('authorizationPermissions')
        ->get();

        foreach($newAuthorizations as $authorization) {

            foreach($authorization->authorizationPermissions as $authorizationPermission) {
                $permission = new Permission();
                $permission->app_id = $authorizationPermission->app_id;
                $permission->access_level = 'all';
                $authorization->permissions()->save($permission);
            }
            
            $authorization->auth_status = 1;
            $authorization->save();

        }

        // Stop old authorizations
        $oldAuthorizations = AuthorizationEmployee::where(function ($query) {
            $query->where([
                ['to_date', '<', date('Y-m-d')],
                ['auth_status', 1]
            ]);
        })
        ->orWhere(function($query) {
            $query->where('auth_status', 2);
        })
        ->get();

        foreach($oldAuthorizations as $authorization) {
            $authorization->permissions()->delete();

            $authorization->auth_status = $authorization->auth_status == 1 ? 4 : 3;
            $authorization->save();
        }


        // stop all authorizations when the direct manager of department was changed
        $validateAuthorizationsManagers = AuthorizationEmployee::whereIn('auth_status', [0, 1])
        ->with('organization')
        ->get();

        foreach($validateAuthorizationsManagers as $authorization) {
            if(!in_array($authorization->employee_id, [$authorization->organization->direct_manager_m_id, $authorization->organization->direct_manager_f_id])) {
                $authorization->permissions()->delete();
                $authorization->auth_status = 3;
                $authorization->save();
            }
        }

    }
}
