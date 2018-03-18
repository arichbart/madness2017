<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Overall;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
        	Overall::create([
        		'user_id' => $user->id,
        		'grandpa_score_total' => 0,
        		'seeded_score_total' => 0,
        		'overall_total' => 0,
        	]);
        }
    }
}
