<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorCodeGradePointToQuestionnaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->double('grade_point')->after('question')->default(8);
            $table->string('colour_code')->after('grade_point')->default('#030303cc');
        });

        Schema::table('questionnaire_weight_points', function (Blueprint $table){
            $table->dropColumn('grade_point');
            $table->dropColumn('colour_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            //
        });
    }
}
