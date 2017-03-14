@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <nav class="navbar navbar-default">
                <a class="navbar-brand" href="/home">Home</a>
                <a class="navbar-brand" href="/pickTeams">Make Selections</a>
                <a class="navbar-brand" href="#">My Teams</a>
                <a class="navbar-brand" href="/scoreboard">Scoreboard</a>
            </nav>
            <h1 class="text-center">My Teams</h1> <br>
            <div class="col-md-6">
                <h3 class="text-center">Grandpa Scoring</h3>
                <ol>
                    <li>{{ $myGrandpa[0]->team1->team_name }} {{ $myGrandpa[0]->team1->seed }}</li>
                    <li>{{ $myGrandpa[0]->team2->team_name }} {{ $myGrandpa[0]->team2->seed }}</li>
                    <li>{{ $myGrandpa[0]->team3->team_name }} {{ $myGrandpa[0]->team3->seed }}</li>
                    <li>{{ $myGrandpa[0]->team4->team_name }} {{ $myGrandpa[0]->team4->seed }}</li>
                </ol>
            </div>
            <div class="col-md-6">
                <h3 class="text-center">Seeded Scoring</h3>
                <ol>
                    <li>{{ $mySpecial[0]->team1->team_name }} {{ $mySpecial[0]->team1->seed }}</li>
                    <li>{{ $mySpecial[0]->team2->team_name }} {{ $mySpecial[0]->team2->seed }}</li>
                    <li>{{ $mySpecial[0]->team3->team_name }} {{ $mySpecial[0]->team3->seed }}</li>
                    <li>{{ $mySpecial[0]->team4->team_name }} {{ $mySpecial[0]->team4->seed }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
