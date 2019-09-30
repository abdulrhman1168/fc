<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMuUsersGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('es_core_users_groups', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('es_core_group_id')->references('id')->on('es_core_groups');;
        $table->integer('user_id')->references('user_id')->on('mu_users');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('es_core_users_groups');
    }
}
