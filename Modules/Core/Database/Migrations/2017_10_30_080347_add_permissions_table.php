<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('es_core_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id');
            $table->string('permissionable_id');
            $table->string('permissionable_type');
            $table->string('access_level');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['app_id', 'permissionable_type', 'permissionable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('es_core_permissions');
    }
}
