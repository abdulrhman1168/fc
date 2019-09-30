<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Core\Entities\DeptMapping;

class DeptmappingSeedingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
            foreach (HRDepartment::all() as  $v)
            {
                DeptMapping::create([
                    'hr_departments'=> $v->id
                ]);
            }


    }
}
