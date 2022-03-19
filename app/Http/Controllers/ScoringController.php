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
use App\Classes\TeamWrapper;

class ScoringController extends Controller
{
    public function index(){
		if (Auth::check()) {
			if (carbon::now() < "2022-03-17 16:15:00.000000" && Auth::user()->name != 'Aaron Richbart') {
				return redirect('/home')
							->withErrors('Scoreboard will be available after the first game begins on Thursday at 12:15pm Eastern');
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

			// call find potential here
			$this->calculatePotential();

			$totals = overall::all();
			$grandpa = grandpa::all();
			$special = special::all();
			
			return view('scoreboard', compact('grandpa','special','totals'));
			
		}
		else {
			return redirect('/home');
		}
	}

	public function calculatePotential(){
		$round1 = array(
			array(1,16),
			array(8,9),
			array(5,12),
			array(4,13),
			array(6,11),
			array(3,14),
			array(7,10),
			array(2,15)
		);
	
		$round2 = array(
			array(1,8),
			array(1,9),
			array(16,8),
			array(16,9),
			array(5,4),
			array(5,13),
			array(12,4),
			array(12,13),
			array(6,3),
			array(6,14),
			array(11,3),
			array(11,14),
			array(7,2),
			array(7,15),
			array(10,2),
			array(10,15)
		);
	
		$round3 = array(
			array(1,5),
			array(1,12),
			array(1,4),
			array(1,13),
			array(16,5),
			array(16,12),
			array(16,4),
			array(16,13),
			array(8,5),
			array(8,12),
			array(8,4),
			array(8,13),
			array(9,5),
			array(9,12),
			array(9,4),
			array(9,13),
			array(6,7),
			array(6,10),
			array(6,2),
			array(6,15),
			array(11,7),
			array(11,10),
			array(11,2),
			array(11,15),
			array(3,7),
			array(3,10),
			array(3,2),
			array(3,15),
			array(14,7),
			array(14,10),
			array(14,2),
			array(14,15)
		);
	
		$round4 = array(
			array(1,6),
			array(1,11),
			array(1,3),
			array(1,14),
			array(1,7),
			array(1,10),
			array(1,2),
			array(1,15),
			array(16,6),
			array(16,11),
			array(16,3),
			array(16,14),
			array(16,7),
			array(16,10),
			array(16,2),
			array(16,15),
			array(8,6),
			array(8,11),
			array(8,3),
			array(8,14),
			array(8,7),
			array(8,10),
			array(8,2),
			array(8,15),
			array(9,6),
			array(9,11),
			array(9,3),
			array(9,14),
			array(9,7),
			array(9,10),
			array(9,2),
			array(9,15),
			array(5,6),
			array(5,11),
			array(5,3),
			array(5,14),
			array(5,7),
			array(5,10),
			array(5,2),
			array(5,15),
			array(12,6),
			array(12,11),
			array(12,3),
			array(12,14),
			array(12,7),
			array(12,10),
			array(12,2),
			array(12,15),
			array(4,6),
			array(4,11),
			array(4,3),
			array(4,14),
			array(4,7),
			array(4,10),
			array(4,2),
			array(4,15),
			array(13,6),
			array(13,11),
			array(13,3),
			array(13,14),
			array(13,7),
			array(13,10),
			array(13,2),
			array(13,15)
		);

		$overallTable = overall::all();
		$grandpaTable = grandpa::all();
		$specialTable = special::all();
		$teamsTable = team::all();
		foreach ($overallTable as $overallRow) {
			foreach($grandpaTable as $grandpaRow){
				if ($grandpaRow->user == $overallRow->user_id) {
					$grandpaTopLeft = $this->createTeamArray($grandpaRow->top_left_team, 'grandpa');
					$grandpaBottomLeft = $this->createTeamArray($grandpaRow->bottom_left_team, 'grandpa');
					$grandpaTopRight = $this->createTeamArray($grandpaRow->top_right_team, 'grandpa');
					$grandpaBottomRight = $this->createTeamArray($grandpaRow->bottom_right_team, 'grandpa');
				}
			}
			foreach($specialTable as $specialRow){
				if ($specialRow->user == $overallRow->user_id) {
					$specialTopLeft = $this->createTeamArray($specialRow->top_left_team, 'special');
					$specialBottomLeft = $this->createTeamArray($specialRow->bottom_left_team, 'special');
					$specialTopRight = $this->createTeamArray($specialRow->top_right_team, 'special');
					$specialBottomRight = $this->createTeamArray($specialRow->bottom_right_team, 'special');
				}
			}
			foreach($teamsTable as $team){
				if ($team->id == $grandpaTopLeft->team_id) {
					$grandpaTopLeft = $this->updateTeamInfo($grandpaTopLeft,$team);
				}
				elseif ($team->id == $grandpaBottomLeft->team_id) {
					$grandpaBottomLeft = $this->updateTeamInfo($grandpaBottomLeft,$team);
				}
				elseif ($team->id == $grandpaTopRight->team_id) {
					$grandpaTopRight = $this->updateTeamInfo($grandpaTopRight,$team);
				}
				elseif ($team->id == $grandpaBottomRight->team_id) {
					$grandpaBottomRight = $this->updateTeamInfo($grandpaBottomRight,$team);
				}

				if ($team->id == $specialTopLeft->team_id) {
					$specialTopLeft = $this->updateTeamInfo($specialTopLeft,$team);
				}
				elseif ($team->id == $specialBottomLeft->team_id) {
					$specialBottomLeft = $this->updateTeamInfo($specialBottomLeft,$team);
				}
				elseif ($team->id == $specialTopRight->team_id) {
					$specialTopRight = $this->updateTeamInfo($specialTopRight,$team);
				}
				elseif ($team->id == $specialBottomRight->team_id) {
					$specialBottomRight = $this->updateTeamInfo($specialBottomRight,$team);
				}
			}

			$this->evaluateEarlyRounds(1,$round1,$grandpaTopLeft,$specialTopLeft);
			$this->evaluateEarlyRounds(1,$round1,$grandpaBottomLeft,$specialBottomLeft);
			$this->evaluateEarlyRounds(1,$round1,$grandpaTopRight,$specialTopRight);
			$this->evaluateEarlyRounds(1,$round1,$grandpaBottomRight,$specialBottomRight);

			$this->evaluateEarlyRounds(2,$round2,$grandpaTopLeft,$specialTopLeft);
			$this->evaluateEarlyRounds(2,$round2,$grandpaBottomLeft,$specialBottomLeft);
			$this->evaluateEarlyRounds(2,$round2,$grandpaTopRight,$specialTopRight);
			$this->evaluateEarlyRounds(2,$round2,$grandpaBottomRight,$specialBottomRight);

			$this->evaluateEarlyRounds(3,$round3,$grandpaTopLeft,$specialTopLeft);
			$this->evaluateEarlyRounds(3,$round3,$grandpaBottomLeft,$specialBottomLeft);
			$this->evaluateEarlyRounds(3,$round3,$grandpaTopRight,$specialTopRight);
			$this->evaluateEarlyRounds(3,$round3,$grandpaBottomRight,$specialBottomRight);

			$this->evaluateEarlyRounds(4,$round4,$grandpaTopLeft,$specialTopLeft);
			$this->evaluateEarlyRounds(4,$round4,$grandpaBottomLeft,$specialBottomLeft);
			$this->evaluateEarlyRounds(4,$round4,$grandpaTopRight,$specialTopRight);
			$this->evaluateEarlyRounds(4,$round4,$grandpaBottomRight,$specialBottomRight);

			$remainingTopLeft = null;
			// if both special and grandpa are the same seed we really need both to move forward
			if ($specialTopLeft->seed == $grandpaTopLeft->seed && $specialTopLeft->eliminated == false) {
				$remainingTopLeft = $specialTopLeft;
				$remainingTopLeft->scoring_type = 'both';
			}
			elseif ($specialTopLeft->eliminated == false) {
				$remainingTopLeft = $specialTopLeft;
			} 
			elseif ($grandpaTopLeft->eliminated == false) {
				$remainingTopLeft = $grandpaTopLeft;
			}

			$remainingBottomLeft = null;
			// if both special and grandpa are the same seed we really need both to move forward
			if ($specialBottomLeft->seed == $grandpaBottomLeft->seed && $specialBottomLeft->eliminated == false) {
				$remainingBottomLeft = $specialBottomLeft;
				$remainingBottomLeft->scoring_type = 'both';
			}
			elseif ($specialBottomLeft->eliminated == false) {
				$remainingBottomLeft = $specialBottomLeft;
			} 
			elseif ($grandpaBottomLeft->eliminated == false) {
				$remainingBottomLeft = $grandpaBottomLeft;
			}

			$remainingTopRight = null;
			// if both special and grandpa are the same seed we really need both to move forward
			if ($specialTopRight->seed == $grandpaTopRight->seed && $specialTopRight->eliminated == false) {
				$remainingTopRight = $specialTopRight;
				$remainingTopRight->scoring_type = 'both';
			}
			elseif ($specialTopRight->eliminated == false) {
				$remainingTopRight = $specialTopRight;
			} 
			elseif ($grandpaTopRight->eliminated == false) {
				$remainingTopRight = $grandpaTopRight;
			}

			$remainingBottomRight = null;
			// if both special and grandpa are the same seed we really need both to move forward
			if ($specialBottomRight->seed == $grandpaBottomRight->seed && $specialBottomRight->eliminated == false) {
				$remainingBottomRight = $specialBottomRight;
				$remainingBottomRight->scoring_type = 'both';
			}
			elseif ($specialBottomRight->eliminated == false) {
				$remainingBottomRight = $specialBottomRight;
			} 
			elseif ($grandpaBottomRight->eliminated == false) {
				$remainingBottomRight = $grandpaBottomRight;
			}

			$this->evaluateLaterRounds(5,$remainingTopLeft,$remainingBottomLeft);
			$this->evaluateLaterRounds(5,$remainingTopRight,$remainingBottomRight);

			$remainingLeftTeam = null;
			if ($remainingTopLeft != null && $remainingBottomLeft == null) {
				$remainingLeftTeam = $remainingTopLeft;
			}
			elseif ($remainingTopLeft == null && $remainingBottomLeft != null) {
				$remainingLeftTeam = $remainingBottomLeft;
			}
			elseif ($remainingTopLeft != null && $remainingBottomLeft != null) {
				if ($remainingTopLeft->eliminated) {
					$remainingLeftTeam = $remainingBottomLeft;
				}
				else {
					$remainingLeftTeam = $remainingTopLeft;
				}
			}

			$remainingRightTeam = null;
			if ($remainingTopRight != null && $remainingBottomRight == null) {
				$remainingRightTeam = $remainingTopRight;
			}
			elseif ($remainingTopRight == null && $remainingBottomRight != null) {
				$remainingRightTeam = $remainingBottomRight;
			}
			elseif ($remainingTopRight != null && $remainingBottomRight != null) {
				if ($remainingTopRight->eliminated) {
					$remainingRightTeam = $remainingBottomRight;
				}
				else {
					$remainingRightTeam = $remainingTopRight;
				}
			}
			$this->evaluateLaterRounds(6,$remainingLeftTeam,$remainingRightTeam);

			var_dump('GTL: ');
			var_dump($grandpaTopLeft->potential_points);
			var_dump('GBL: ');
			var_dump($grandpaBottomLeft->potential_points);
			var_dump('GTR: ');
			var_dump($grandpaTopRight->potential_points);
			var_dump('GBR: ');
			var_dump($grandpaBottomRight->potential_points);
			var_dump('STL: ');
			var_dump($specialTopLeft->potential_points);
			var_dump('SBL: ');
			var_dump($specialBottomLeft->potential_points);
			var_dump('STR: ');
			var_dump($specialTopRight->potential_points);
			var_dump('SBR: ');
			var_dump($specialBottomRight->potential_points);

			$potentialPointsRemaining = $grandpaTopLeft->potential_points + $grandpaBottomLeft->potential_points + $grandpaTopRight->potential_points + $grandpaBottomRight->potential_points + $specialTopLeft->potential_points + $specialBottomLeft->potential_points + $specialTopRight->potential_points + $specialBottomRight->potential_points;
			$overallRow->potential_score = $overallRow->overall_total + $potentialPointsRemaining;
			$overallRow->save();
			// remaining TL vs remaining BL
			// remaining TR vs remaining BR
			// loop over round 1
			// check for matchups of teams that aren't eliminated and haven't played 1 game yet
			// if matchup grant potential points to special team unless it is a 1 seed
			// account for both teams being the same seed
			// if no matchup grant points to each teamWrap
			
			// same for round 2 - 4 just add number to games required

			// round five matchup remaining top left with remaining bottom left
			// and top right with bottom right

			// round 6 - matchup remaining teams
		}
	}

	public function createTeamArray($teamId, $type){
		$teamWrap = new TeamWrapper;
		$teamWrap->team_id = $teamId;
		$teamWrap->seed = 0;
		$teamWrap->eliminated = false;
		$teamWrap->potential_points = 0;
		$teamWrap->scoring_type = $type;
		return $teamWrap;

	}

	public function updateTeamInfo($teamWrap, $team){
		// add seed and eliminated to array
		$eliminated = false;
		if ($team->eliminated == 1) {
			$eliminated = true;
		}
		$teamWrap->seed = $team->seed;
		$teamWrap->eliminated = $eliminated;
		$teamWrap->games_played = $team->wins;
		return $teamWrap;
	}
			// loop over round 
			// check for matchups of teams that aren't eliminated and haven't played 1 game yet
			// if matchup grant potential points to special team unless it is a 1 seed
			// account for both teams being the same seed
			// if no matchup grant points to each teamWrap
	public function evaluateEarlyRounds($roundNumber,$roundMatchUps,$grandpaTeam,$specialTeam){
		// if both teams remain with different seeds and they both haven't played this round, look for matchup
		if (!$grandpaTeam->eliminated && !$specialTeam->eliminated && $grandpaTeam->seed != $specialTeam->seed && $grandpaTeam->games_played < $roundNumber && $specialTeam->games_played < $roundNumber) {
			$isMatchUp = false;
			foreach($roundMatchUps as $matchUp){
				if(in_array($grandpaTeam->seed, $matchUp) && in_array($specialTeam->seed, $matchUp)){
					$isMatchUp = true;
				}
			}
	
			if ($isMatchUp) {
				if($specialTeam->seed != 1){
					$this->giveSpecialPoints($specialTeam,$roundNumber);
					$grandpaTeam->eliminated = true;
				}
				else { // this means the special seed is a one and is not more valuable than any grandpa pick
					$this->giveGrandpaPoints($grandpaTeam);
					$specialTeam->eliminated = true;
				}
			}
			// This means the two teams do not match up this round. Award both with points
			else { 
				$this->giveGrandpaPoints($grandpaTeam);
				$this->giveSpecialPoints($specialTeam,$roundNumber);
			}
		}
		// if both teams remain with the same seeds and neither have played this round, award both with points
		elseif (!$grandpaTeam->eliminated && !$specialTeam->eliminated && $grandpaTeam->games_played < $roundNumber && $specialTeam->games_played < $roundNumber) {
			$this->giveGrandpaPoints($grandpaTeam);
			$this->giveSpecialPoints($specialTeam,$roundNumber);
		}
		// if both teams are eliminated or both have played this round, do nothing
		elseif (($grandpaTeam->eliminated && $specialTeam->eliminated) || ($grandpaTeam->games_played >= $roundNumber && $specialTeam->games_played >= $roundNumber)) { 
			return;
		} 
		// if grandpaTeam is the only one eliminated or the only one that played this round give points to special
		elseif (($grandpaTeam->eliminated || $grandpaTeam->games_played >= $roundNumber) && (!$specialTeam->eliminated && $specialTeam->games_played < $roundNumber)) {
			// give special the points
			$this->giveSpecialPoints($specialTeam,$roundNumber);
		}
		// if specialTeam is the only one eliminated or the only one that played this round give points to grandpa
		elseif (($specialTeam->eliminated || $specialTeam->games_played >= $roundNumber) && (!$grandpaTeam->eliminated && $grandpaTeam->games_played < $roundNumber) ) {
			// give grandpa the points
			$this->giveGrandpaPoints($grandpaTeam);
		}
	}

	// TODO: add in round check vs games played
	public function evaluateLaterRounds($round,$teamA,$teamB){
		if ($teamA == null && $teamB != null) {
			if ($teamB->games_played < $round) {
				if ($teamB->scoring_type == 'grandpa') {
					$this->giveGrandpaPoints($teamB);
				}
				elseif ($teamB->scoring_type == 'special') {
					$this->giveSpecialPoints($teamB,$round);
				}
				elseif ($teamB->scoring_type == 'both') {
					$this->giveGrandpaPoints($teamB);
					$this->giveSpecialPoints($teamB,$round);
				}
			}
		}
		elseif ($teamA != null && $teamB == null) {
			if ($teamA->games_played < $round) {
				if ($teamA->scoring_type == 'grandpa') {
					$this->giveGrandpaPoints($teamA);
				}
				elseif ($teamA->scoring_type == 'special') {
					$this->giveSpecialPoints($teamA,$round);
				}
				elseif ($teamA->scoring_type == 'both') {
					$this->giveGrandpaPoints($teamA);
					$this->giveSpecialPoints($teamA,$round);
				}
			}
		}
		elseif ($teamA != null && $teamB != null) {
			if ($teamA->games_played < $round && $teamB->games_played < $round) {
				// if both teams are "both" scoring type award points to highest seed...if equal just give to A
				if ($teamA->scoring_type == 'both' && $teamB->scoring_type == 'both') {
					if ($teamA->seed >= $teamB->seed) {
						$this->giveSpecialPoints($teamA,$round);
						$this->giveGrandpaPoints($teamA);
						$teamB->eliminated = true;
					}
					else {
						$this->giveSpecialPoints($teamB,$round);
						$this->giveGrandpaPoints($teamB);
						$teamA->eliminated = true;
					}
				}
				// if one is both and the other is grandpa, award to the one that has both
				elseif ($teamA->scoring_type == 'both' && $teamB->scoring_type == 'grandpa') {
					$this->giveSpecialPoints($teamA,$round);
					$this->giveGrandpaPoints($teamA);
					$teamB->eliminated = true;
				}
				elseif ($teamB->scoring_type == 'both' && $teamA->scoring_type == 'grandpa') {
					$this->giveSpecialPoints($teamB,$round);
					$this->giveGrandpaPoints($teamB);
					$teamA->eliminated = true;
				}
				// if one is both and the other is special, evaluate the potential remaining and award to highest
				elseif ($teamA->scoring_type == 'both' && $teamB->scoring_type == 'special') {
					$potentialTeamA = 0;
					$potentialTeamB = 0;
					if ($round == 5) {
						$potentialTeamA = 6 + 6 + ($teamA->seed * 5) + ($teamA->seed * 6);
						$potentialTeamB = ($teamB->seed * 5) + ($teamB->seed * 6);
					}
					elseif ($round == 6) {
						$potentialTeamA = 6 + ($teamA->seed * 6);
						$potentialTeamB = ($teamB->seed * 6);
					}
					
					// Since teamA has more potential remaining and is both types, give special and grandpa points
					if ($potentialTeamA > $potentialTeamB) {
						$this->giveSpecialPoints($teamA,$round);
						$this->giveGrandpaPoints($teamA);
						$teamB->eliminated = true;
					}
					// Since teamB has more potential remaining and is special type, only give special points
					else {
						$this->giveSpecialPoints($teamB,$round);
						$teamA->eliminated = true;
					}
					
				}
				elseif ($teamA->scoring_type == 'special' && $teamB->scoring_type == 'both') {
					$potentialTeamA = 0;
					$potentialTeamB = 0;
					if ($round == 5) {
						$potentialTeamB = 6 + 6 + ($teamB->seed * 5) + ($teamB->seed * 6);
						$potentialTeamA = ($teamA->seed * 5) + ($teamA->seed * 6);
					}
					elseif ($round == 6) {
						$potentialTeamB = 6 + ($teamB->seed * 6);
						$potentialTeamA = ($teamA->seed * 6);
					}

					// Since teamA has more potential remaining and is special type, only give special points
					if ($potentialTeamA > $potentialTeamB) {
						$this->giveSpecialPoints($teamA,$round);
						$teamB->eliminated = true;
					}
					// Since teamB has more potential remaining and is both types, give special and grandpa points
					else {
						$this->giveSpecialPoints($teamB,$round);
						$this->giveGrandpaPoints($teamB);
						$teamA->eliminated = true;
					}
				}
				// if both are special, award points to highest seed...if equal just give to A
				elseif ($teamA->scoring_type == 'special' && $teamB->scoring_type == 'special') {
					if ($teamA->seed >= $teamB->seed) {
						$this->giveSpecialPoints($teamA,$round);
						$teamB->eliminated = true;
					}
					else {
						$this->giveSpecialPoints($teamB,$round);
						$teamA->eliminated = true;
					}
				}
				// if only teamA is special and it is not a 1 seed, grant teamA points
				elseif ($teamA->scoring_type == 'special' && $teamA->seed != 1) {
					$this->giveSpecialPoints($teamA,$round);
					$teamB->eliminated = true;
				}
				// if only teamB is special and it is not a 1 seed, grant teamB points
				elseif ($teamB->scoring_type == 'special' && $teamB->seed != 1) {
					$this->giveSpecialPoints($teamB,$round);
						$teamA->eliminated = true;
				}
				// if we get here we know that either they are both grandpa and it doesn't matter which we pick
				// or one is grandpa and the other is a special with seed 1.  No matter what, we want grandpa
				elseif ($teamA->scoring_type == 'grandpa') {
					$this->giveGrandpaPoints($teamA);
					$teamB->eliminated = true;
				}
				elseif ($teamB->scoring_type == 'grandpa') {
					$this->giveGrandpaPoints($teamB);
					$teamA->eliminated = true;
				}
			}
		}
	}

	public function giveGrandpaPoints($team){
		$team->potential_points += 6;
	}

	public function giveSpecialPoints($team,$round){
		$thisRoundPoints = $team->seed * $round;
		$team->potential_points += $thisRoundPoints;
	}

}
