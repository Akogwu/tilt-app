<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('payment_by');
            //result or school capacity
            $table->string('payment_type');
            //session_id or subscription_id
            $table->string('payment_for')->nullable();
            $table->string('reference')->nullable();
            $table->string('transaction_id')->nullable();
            $table->double('amount')->default(0.00);
            $table->boolean('status')->default(false);
            $table->integer('quantity')->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
