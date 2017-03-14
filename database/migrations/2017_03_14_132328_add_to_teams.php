<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->Integer('grandpa_points')->nullable();
            $table->Integer('seeded_points')->nullable();
            $table->Integer('eliminated')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('grandpa_points');
            $table->dropColumn('seeded_points');
            $table->dropColumn('eliminated');

        });
    }
}
