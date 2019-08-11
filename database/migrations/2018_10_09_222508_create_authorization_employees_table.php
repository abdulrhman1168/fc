<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorization_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('organization_id');
            $table->integer('auth_employee_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('auth_status');
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
        Schema::dropIfExists('authorization_employees');
    }
}
