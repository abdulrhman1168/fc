<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('es_core_groups', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name')->unique();
        $table->string('name_en')->unique();
        $table->string('key')->unique()->nullable();
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
      Schema::drop('es_core_groups');
    }
}
