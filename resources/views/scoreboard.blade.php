@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <nav class="navbar navbar-default">
                <a class="navbar-brand" href="/home">Home</a>
                <a class="navbar-brand" href="/pickTeams">Make Selections</a>
                <a class="navbar-brand" href="/myTeams">My Teams</a>
                <a class="navbar-brand" href="#">Scoreboard</a>
            </nav>
            <h1 class="text-center">Scoreboard</h1> <br>
        </div>
        <div class="col-md-6">
            <h2 class="text-center">Grandpa Scoring</h2>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>East</th>
                    <th>West</th>
                    <th>MidWest</th>
                    <th>South</th>
                    <th>Total Points</th>
                </tr>
                @foreach ($grandpa->sortByDesc('score') as $team)
                <tr> 
                    <td>{{ $team->getUser->name }}</td>
                    <td <?php if ( $team->team1->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team1->team_name }} {{ $team->team1->seed }}</td>
                    <td <?php if ( $team->team1->eliminated == 2) { echo "class='danger'";}  ?> >{{ $team->team2->team_name }} {{ $team->team2->seed }}</td>
                    <td <?php if ( $team->team1->eliminated == 3) { echo "class='danger'";}  ?> >{{ $team->team3->team_name }} {{ $team->team3->seed }}</td>
                    <td <?php if ( $team->team1->eliminated == 4) { echo "class='danger'";}  ?> >{{ $team->team4->team_name }} {{ $team->team4->seed }}</td>
                    <td>{{ $team->score }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="col-md-6">
            <h2 class="text-center">Seeded Scoring</h2>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>East</th>
                    <th>West</th>
                    <th>MidWest</th>
                    <th>South</th>
                    <th>Total Points</th>
                </tr>
                @foreach ($special->sortByDesc('score') as $team)
                <tr>
                    <td>{{ $team->getUser->name }}</td>
                    <td <?php if ( $team->team1->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team1->team_name }} {{ $team->team1->seed }}</td>
                    <td <?php if ( $team->team2->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team2->team_name }} {{ $team->team2->seed }}</td>
                    <td <?php if ( $team->team3->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team3->team_name }} {{ $team->team3->seed }}</td>
                    <td <?php if ( $team->team4->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team4->team_name }} {{ $team->team4->seed }}</td>
                    <td>{{ $team->score }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
