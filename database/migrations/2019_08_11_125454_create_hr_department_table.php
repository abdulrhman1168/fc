<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_department', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->integer('type')->nullable();
            $table->integer('status')->default(0);
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('hr_department');
    }
}
