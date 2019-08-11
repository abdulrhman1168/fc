<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EsCorePermissionsScopes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('es_core_permissions_scopes', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('es_core_permission_id')->references('id')->on('es_core_permissions');
        $table->string('es_core_scope_id')->references('id')->on('es_core_scopes');
        $table->text('data')->nullable();
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
      Schema::drop('es_core_permissions_scopes');
    }
}
