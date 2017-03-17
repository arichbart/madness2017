<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overalls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->Integer('user_id');
            $table->Integer('grandpa_score_total');
            $table->Integer('seeded_score_total');
            $table->Integer('overall_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overalls');
    }
}
