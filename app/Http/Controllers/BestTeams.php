<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\team;

class BestTeams extends Controller
{
	public function getTeamScores(){
	    $eastTeams = team::where('region_id', 1)
	    		->where('wins', '>', 0)
	    		->get();
	   	$westTeams = team::where('region_id', 2)
	   			->where('wins', '>', 0)
	    		->get();
		$midWestTeams = team::where('region_id', 3)
				->where('wins', '>', 0)
	    		->get();
		$southTeams = team::where('region_id', 4)
				->where('wins', '>', 0)
	    		->get();

		return view('bestTeam', compact('eastTeams','westTeams','midWestTeams','southTeams'));
	}
}
