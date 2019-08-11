<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoreScopes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('es_core_scopes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('name_en');
          $table->string('resource_table_name')->nullable();
          $table->string('resource_join_key')->nullable();
          $table->string('user_table_name')->nullable();
          $table->string('scope_table_name')->nullable();
          $table->string('scope_join_key')->nullable();
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
      Schema::drop('es_core_scopes');
    }
}
