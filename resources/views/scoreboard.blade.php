@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="text-center">Scoreboard</h1> <br>
        </div>
        <div class="col-md-6">
            <h2 class="text-center">Grandpa Scoring</h2>
            <table class="table table-hover table-bordered">
                <tr>
                    <th>Name</th>
                    <th>West</th>
                    <th>East</th>
                    <th>South</th>
                    <th>Midwest</th>
                    <th>Total Points</th>
                </tr>
                @foreach ($grandpa->sortByDesc('score') as $team)
                <tr> 
                    <td><strong>{{ $team->getUser->name }}</strong></td>
                    <td <?php if ( $team->team1->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team1->team_name }} {{ $team->team1->seed }}</td>
                    <td <?php if ( $team->team2->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team2->team_name }} {{ $team->team2->seed }}</td>
                    <td <?php if ( $team->team3->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team3->team_name }} {{ $team->team3->seed }}</td>
                    <td <?php if ( $team->team4->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team4->team_name }} {{ $team->team4->seed }}</td>
                    <td>{{ $team->score }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="col-md-6">
            <h2 class="text-center">Seeded Scoring</h2>
            <table class="table table-hover table-bordered">
                <tr>
                    <th>Name</th>
                    <th>West</th>
                    <th>East</th>
                    <th>South</th>
                    <th>Midwest</th>
                    <th>Total Points</th>
                </tr>
                @foreach ($special->sortByDesc('score') as $team)
                <tr>
                    <td><strong>{{ $team->getUser->name }}</strong></td>
                    <td <?php if ( $team->team1->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team1->team_name }} {{ $team->team1->seed }}</td>
                    <td <?php if ( $team->team2->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team2->team_name }} {{ $team->team2->seed }}</td>
                    <td <?php if ( $team->team3->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team3->team_name }} {{ $team->team3->seed }}</td>
                    <td <?php if ( $team->team4->eliminated == 1) { echo "class='danger'";}  ?> >{{ $team->team4->team_name }} {{ $team->team4->seed }}</td>
                    <td>{{ $team->score }}</td>
                </tr>
                @endforeach
            </table>
            <br>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <h1 class="text-center">Overall Scoring</h1>
            <table class="table table-hover table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Grandpa Total (x6)</th>
                    <th>Seeded Total</th>
                    <th>Grand Total</th>
                    <th>Potential Final Score</th>
                </tr>
                @foreach ($totals->sortByDesc('overall_total') as $user)
                <tr> 
                    <td><strong>{{ $user->getUser->name }}</strong></td>
                    <td>{{ $user->grandpa_score_total }}</td>
                    <td>{{ $user->seeded_score_total }}</td>
                    <td>{{ $user->overall_total }}</td>
                    <td>{{ $user->potential_score }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
