<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryStateToStudentPrivateLearner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
           $table->unsignedBigInteger('state_id')->after('age')->nullable();
           $table->unsignedBigInteger('country_id')->after('state_id')->nullable();

           $table->foreign('state_id')->references('id')->on('states_provinces')->onUpdate('cascade');
           $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade');
        });
        Schema::table('private_learners', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->after('age')->nullable();
            $table->unsignedBigInteger('country_id')->after('state_id')->nullable();

            $table->foreign('state_id')->references('id')->on('states_provinces')->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade');
        });
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
