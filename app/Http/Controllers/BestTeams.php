<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\team;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BestTeams extends Controller
{
	public function getTeamScores(){
		if (Auth::check()) {
			if (carbon::now() < "2021-03-19 16:15:00.000000" && Auth::user()->name != 'Aaron Richbart') {
				return redirect('/home')
					->withErrors('Best teams will be available after the first game begins on Friday at 12:15pm Eastern');
			}

			$westTeams = team::where('region_id', 1)
					->where('wins', '>', 0)
					->get();
			$eastTeams = team::where('region_id', 2)
					->where('wins', '>', 0)
					->get();
			$southTeams = team::where('region_id', 3)
					->where('wins', '>', 0)
					->get();
			$midWestTeams = team::where('region_id', 4)
					->where('wins', '>', 0)
					->get();

			return view('bestTeam', compact('eastTeams','westTeams','midWestTeams','southTeams'));
			
		}
		else {
			return redirect('/home');
		}
	}
}
