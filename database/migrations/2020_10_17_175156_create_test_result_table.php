<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('session_id');
            $table->double('avg_score');
            $table->double('total_score');
            $table->double('obtainable_score');
            $table->text('section_score_detail');
            $table->text('group_score_detail');
            $table->boolean('payment_status')->default(false);
            $table->timestamps();
            $table->foreign('session_id')->references('id')->on('user_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
