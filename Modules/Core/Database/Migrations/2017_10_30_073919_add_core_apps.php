<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoreApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('es_core_apps', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('name_en')->nullable();
        $table->string('resource_name')->unique()->nullable();
        $table->string('icon')->nullable();
        $table->integer('sort')->default(0);
        $table->integer('parent_id')->default(0)->references('id')->on('es_core_apps');
        $table->string('frontend_path')->nullable();
        $table->string('li_color')->nullable();
        $table->boolean('is_main_root')->default(false);
        $table->boolean('displayed_in_menu')->default(false);
        $table->string('menu_type')->nullable();
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
      Schema::drop('es_core_apps');
    }
}
