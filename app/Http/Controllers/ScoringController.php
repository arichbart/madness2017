<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\grandpa;
use App\special;
use App\team;
use App\User;
use Carbon\Carbon;
use App\overall;

class ScoringController extends Controller
{
    public function index(){
		if (Auth::check()) {
			if (carbon::now() < "2021-03-19 16:15:00.000000" && Auth::user()->name != 'Aaron Richbart') {
				return redirect('/home')
							->withErrors('Scoreboard will be available after the first game begins on Friday at 12:15pm Eastern');
			}
			$overall = overall::all();
			if($overall->isEmpty()) {
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
			$teamsPre = team::all();
			foreach ($teamsPre as $team) {
				$grandpaScore = $team->wins;
				$team->grandpa_points = $grandpaScore;
				$specialScore = 0;
				$counter = $team->wins;
				for ($i = $counter; $i > 0; $i--) { 
					$specialScore = ($counter * ($team->seed)) + $specialScore;	
					$counter--;
				}
				$team->seeded_points = $specialScore;
				$team->save();
			}
			$grandpaPre = grandpa::all();
			$overall = overall::all();
			foreach ($grandpaPre as $grandpaPicks) {
				$totalScore = $grandpaPicks->team1->grandpa_points + $grandpaPicks->team2->grandpa_points + $grandpaPicks->team3->grandpa_points + $grandpaPicks->team4->grandpa_points;
				$grandpaPicks->score = $totalScore;
				foreach($overall as $user){
					if($grandpaPicks->user == $user->user_id){
						$user->grandpa_score_total = $totalScore * 6;
						$user->save();
					}
				}
				$grandpaPicks->save();
			}

			
			$specialPre = special::all();
			foreach ($specialPre as $specialPicks) {
				$totalScore = $specialPicks->team1->seeded_points + $specialPicks->team2->seeded_points + $specialPicks->team3->seeded_points +$specialPicks->team4->seeded_points;
				$specialPicks->score = $totalScore;
				foreach($overall as $user){
					if($specialPicks->user == $user->user_id){
						$user->seeded_score_total = $totalScore;
						$user->save();
					}
				}
				$specialPicks->save();
			}
			$overallScore = overall::all();
			foreach ($overallScore as $userScore) {
				$userScore->overall_total = $userScore->grandpa_score_total + $userScore->seeded_score_total;
				$userScore->save();
			}

			$totals = overall::all();
			$grandpa = grandpa::all();
			$special = special::all();
			
			return view('scoreboard', compact('grandpa','special','totals'));
			
		}
		else {
			return redirect('/home');
		}
	}

}
