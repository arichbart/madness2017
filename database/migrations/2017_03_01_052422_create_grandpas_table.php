<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrandpasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grandpas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('user');
            $table->Integer('top_left_team');
            $table->Integer('top_right_team');
            $table->Integer('bottom_left_team');
            $table->Integer('bottom_right_team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grandpas');
    }
}
