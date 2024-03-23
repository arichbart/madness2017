<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use App\team;

class AutoScoreUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();
        $currentHour = substr($now,11,2); // this returns just the hour from the now()
        $startPM = Carbon::createFromTimeString('15:30'); // 1:30pm
        // $endPM = Carbon::createFromTimeString('24:00');
        // $startAM = Carbon::createFromTimeString('00:30');
        $endAM = Carbon::createFromTimeString('06:01'); // 2:01 am

        // 2024 added the modulus to only do the even hours for the callout
        // you get 20 free callouts per day, so since we have 2 servers, we need half the callouts or we pass the 20
        // in the future we should add a game invite token and have everything on one server
        if (!$now->between($endAM, $startPM) && $currentHour % 2 == 0) {
        // if ($now->between($startPM, $endPM) || $now->between($startAM, $endAM)) {
            $today = $now->toDateString();
            $yesterday = Carbon::yesterday()->toDateString();
            $curl = curl_init();
    
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://sportspage-feeds.p.rapidapi.com/games?status=final&league=NCAAB&date=" . $today . "," . $yesterday,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: sportspage-feeds.p.rapidapi.com",
                    "x-rapidapi-key: b4df0351ddmshd07b328b06fc218p1b7c43jsn19a67f84d950"
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $remainingTeams = team::where('eliminated',null)->get(); 
                $teamArray = array();
                foreach($remainingTeams as $remainingTeam) {
                    $teamArray = array_add($teamArray, $remainingTeam->team_name, $remainingTeam);
                }
                $completeGames = json_decode($response);
    
                foreach($completeGames->results as $game) {
                    if (array_key_exists($game->teams->away->team,$teamArray) && array_key_exists($game->teams->home->team,$teamArray)) {
                        $awayTeam = $teamArray[$game->teams->away->team];
                        $homeTeam = $teamArray[$game->teams->home->team];
                        if($game->scoreboard->score->away > $game->scoreboard->score->home ) {
                            // away won
                            $awayTeam->wins = $awayTeam->wins + 1;
                            $homeTeam->eliminated = 1;
                        }
                        else {
                            // home won
                            $homeTeam->wins = $homeTeam->wins + 1;
                            $awayTeam->eliminated = 1;
                        }
                        $awayTeam->save();
                        $homeTeam->save();
                    }
                }
            }
        }
    }
}
