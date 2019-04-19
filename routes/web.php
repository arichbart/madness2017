<?php
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/pickTeams', 'TeamSelectionController@getTeams');


Route::POST('/myTeams', 'TeamSelectionController@postTeams');
route::get('/myTeams', 'TeamSelectionController@showMyTeams');

route::get('/scoreboard', 'ScoringController@index');

route::get('/best', 'BestTeams@getTeamScores');



Auth::routes();

Route::get('/home', 'HomeController@index');
