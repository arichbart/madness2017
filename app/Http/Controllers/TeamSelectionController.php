<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\team;
use App\grandpa;
use App\special;
use auth;

class TeamSelectionController extends Controller
{
    public function getTeams() {
    	$topLeft = team::where('region_id', 1)
    		->orderby('seed')
    		->get();
    	$topRight = team::where('region_id', 2)
    		->orderby('seed')
    		->get();
    	$bottomLeft = team::where('region_id', 3)
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
    	if ($now > "2019-03-21 16:15:00.000000") {
    		return redirect('/pickTeams')
                        ->withErrors('You are too late.  Games have already started')
                        ->withInput();
    	}

    	$grandpaTL = $_POST['grandpaTL'];
    	$grandpaBL = $_POST['grandpaBL'];
    	$grandpaTR = $_POST['grandpaTR'];
    	$grandpaBR = $_POST['grandpaBR'];
    	$specialTL = $_POST['specialTL'];
    	$specialBL = $_POST['specialBL'];
    	$specialTR = $_POST['specialTR'];
    	$specialBR = $_POST['specialBR'];

    	if($grandpaTL == 1 && ($grandpaBL == 17 || $grandpaTR == 33 || $grandpaBR == 49) || $grandpaBL == 17 && ($grandpaTL == 1 || $grandpaTR == 33 || $grandpaBR == 49) || $grandpaTR == 33 && ($grandpaTL == 1 || $grandpaBL == 17 || $grandpaBR == 49) || $grandpaBR == 49 && ($grandpaTL == 1 || $grandpaBL == 17 || $grandpaTR == 33)) {
    		return redirect('/pickTeams')
                        ->withErrors('You can only Pick one team with a 1 seed for Grandpa Scoring')
                        ->withInput();
    	}

    	$grandpa = new grandpa;
    	$grandpa->user = auth::user()->id;
    	$grandpa->top_left_team = $grandpaTL;
    	$grandpa->bottom_left_team = $grandpaBL;
    	$grandpa->top_right_team = $grandpaTR;
    	$grandpa->bottom_right_team = $grandpaBR;
    	$user = grandpa::where('user', auth::user()->id)
    		->get();
		if(count($user) > 0){
			if ($user[0]->user){
				$user[0]->top_left_team = $grandpaTL;
				$user[0]->bottom_left_team = $grandpaBL;
				$user[0]->top_right_team = $grandpaTR;
				$user[0]->bottom_right_team = $grandpaBR;
				$user[0]->save();
			} else {
				$grandpa->save();
			}
		} else {
			$grandpa->save();
		}
		
    	

    	$special = new special;
    	$special->user = auth::user()->id;
    	$special->top_left_team = $specialTL;
    	$special->bottom_left_team = $specialBL;
    	$special->top_right_team = $specialTR;
    	$special->bottom_right_team = $specialBR;
    	$user = special::where('user', auth::user()->id)
    		->get();
		if(count($user) > 0){
			if ($user[0]->user){
				$user[0]->top_left_team = $specialTL;
				$user[0]->bottom_left_team = $specialBL;
				$user[0]->top_right_team = $specialTR;
				$user[0]->bottom_right_team = $specialBR;
				$user[0]->save();
			} else {
				$special->save();
			}
		} else {
			$special->save();
		}
    	
    	

    	return redirect()->to('myTeams');
    	
    	
    }

    public function showMyTeams() {

    	$myGrandpa = grandpa::where('user', auth::user()->id)
    		->get();
    	$mySpecial = special::where('user', auth::user()->id)
			->get();

    	return view('myTeams', compact('myGrandpa', 'mySpecial'));
    }
}
