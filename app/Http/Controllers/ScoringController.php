<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\grandpa;
use App\special;
use App\team;
use App\User;
use Carbon\Carbon;

class ScoringController extends Controller
{
    public function index(){
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
    	
    	foreach ($grandpaPre as $grandpaPicks) {
    		$totalScore = $grandpaPicks->team1->grandpa_points + $grandpaPicks->team2->grandpa_points + $grandpaPicks->team3->grandpa_points + $grandpaPicks->team4->grandpa_points;
    		$grandpaPicks->score = $totalScore;
    		$grandpaPicks->save();
    	}

    	$teams = team::all();
    	$specialPre = special::all();
    	foreach ($specialPre as $specialPicks) {
    		$totalScore = $specialPicks->team1->seeded_points + $specialPicks->team2->seeded_points + $specialPicks->team3->seeded_points +$specialPicks->team4->seeded_points;
    		$specialPicks->score = $totalScore;
    		$specialPicks->save();
    	}

    	$grandpa = grandpa::all();
    	$special = special::all();
    	$now = carbon::now();
    	if ($now < "2017-03-16 16:15:00.000000") {
    		return redirect('/home')
                        ->withErrors('Scoreboard will be available after the first game begins on Thursday at 12:15pm Eastern');
    	} else {
    		return view('scoreboard', compact('grandpa','special'));
    	}
	    
	}

}
