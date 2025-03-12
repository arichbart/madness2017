<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\team;
use App\grandpa;
use App\special;
use App\overall;
use Illuminate\Support\Facades\Auth;
// use auth;

class TeamSelectionController extends Controller
{
    public function getTeams() {
		$now = carbon::now(); 
		if (!Auth::check() || $now > "2025-03-20 16:15:00.000000") { // 16:15 UTC = 12:15 EST after daylight savings
			return redirect()->to('/home');
		}
			
    	$topLeft = team::where('region_id', 1)
    		->orderby('seed')
    		->get();
			$bottomLeft = team::where('region_id', 2)
				->orderby('seed')
				->get();
    	$topRight = team::where('region_id', 3)
    		->orderby('seed')
    		->get();
    	$bottomRight = team::where('region_id', 4)
    		->orderby('seed')
    		->get();
        $now = Carbon::now();      
    	return view('pickTeams', compact('topLeft','topRight','bottomLeft','bottomRight','now'));
    }

    public function postTeams() {
    	$now = carbon::now();
    	if ($now > "2025-03-20 16:15:00.000000") {
    		return back()
				->withErrors('You are too late.  Games have already started')
				->withInput();
    	}

    	$grandpaTL = request('grandpaTL');
    	$grandpaBL = request('grandpaBL');
    	$grandpaTR = request('grandpaTR');
    	$grandpaBR = request('grandpaBR');
    	$specialTL = request('specialTL');
    	$specialBL = request('specialBL');
    	$specialTR = request('specialTR');
    	$specialBR = request('specialBR');

		$teamsWithOneSeed = [1, 17, 33, 49];
		$grandpaTeamIds = [$grandpaTL, $grandpaBL, $grandpaTR, $grandpaBR];
		
    	if(count(array_intersect($teamsWithOneSeed, $grandpaTeamIds)) > 1) {
    		return back()
				->withErrors('You can only Pick one team with a 1 seed for Grandpa Scoring')
				->withInput();
    	}

		grandpa::updateOrCreate(['user' => auth::user()->id], [
			'top_left_team' => $grandpaTL,
			'bottom_left_team' => $grandpaBL,
			'top_right_team' => $grandpaTR,
			'bottom_right_team' => $grandpaBR,
		]);

		auth()->user()->special()->updateOrCreate(['user' => auth::user()->id], [
			'top_left_team' => $specialTL,
			'bottom_left_team' => $specialBL,
			'top_right_team' => $specialTR,
			'bottom_right_team' => $specialBR,
		]);

		overall::updateOrCreate(['user_id' => auth::user()->id], [
			'user_id' => auth::user()->id,
			'potential_score' => 0,
			'grandpa_score_total' => 0,
			'seeded_score_total' => 0,
			'overall_total' => 0,
		]);

    	return redirect()->to('myTeams');
    }

    public function showMyTeams() {

		if (Auth::check()) {
			$myGrandpa = grandpa::where('user', auth::user()->id)
				->get();
			$mySpecial = special::where('user', auth::user()->id)
				->get();

			if($myGrandpa != null && $mySpecial != null){
				return view('myTeams', compact('myGrandpa', 'mySpecial'));
			}
			else {
				return redirect('/home')
					->withErrors('Select teams first');
			}
		}
		else {
			return redirect('/home')
				->withErrors('Login first');
		}

    }
}
