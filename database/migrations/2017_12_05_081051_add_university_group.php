<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Entities\Core\Group;
use Modules\Auth\Entities\Core\User;

class AddUniversityGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $group = Group::where('key', Group::$unifiedGroups['university'])->first();

      if ($group == null) {
        $attributes = [
          'name' => 'مجموعة الجامعة',
          'name_en' => 'University Group',
          'key' => Group::$unifiedGroups['university']
        ];


        // create group
        $group = Group::create($attributes);

        // Get users Ids
        $usersIds = User::pluck('user_id')->toArray();

        //sync users to group
        $group->users()->sync($usersIds);
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
