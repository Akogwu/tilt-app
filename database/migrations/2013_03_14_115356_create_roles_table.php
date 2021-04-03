<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('role');
            $table->timestamps();
            $table->softDeletes();
        });

        $rows = ['ADMIN','SCHOOL_ADMIN','PRIVATE_LEARNER','STUDENT','ANONYMOUS'];
        foreach ($rows as $row):
            DB::table('roles')->insert([
                'id'   => $row,
                'role'     => $row
            ]);
        endforeach;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
