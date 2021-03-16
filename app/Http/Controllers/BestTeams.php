<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\team;

use Carbon\Carbon;

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

		if (carbon::now() < "2021-03-19 16:15:00.000000") {
			return redirect('/home')
				->withErrors('Best teams will be available after the first game begins on Friday at 12:15pm Eastern');
		} else {
			return view('bestTeam', compact('eastTeams','westTeams','midWestTeams','southTeams'));
		}		
	}
}
