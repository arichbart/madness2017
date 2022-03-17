@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="text-center">Best Teams</h1> <br>
        </div>
            
        <div class="col-md-12">
            <h1 class="text-center">Team Seeded Scores</h1>
            <div class="col-md-3">
                <h3 class="text-center">West</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Seeded Score</th>
                </tr>
                @foreach ($westTeams->sortByDesc('seeded_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->seeded_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>

            <div class="col-md-3">
                <h3 class="text-center">East</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Seeded Score</th>
                </tr>
                @foreach ($eastTeams->sortByDesc('seeded_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->seeded_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>

            <div class="col-md-3">
                <h3 class="text-center">South</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Seeded Score</th>
                </tr>
                @foreach ($southTeams->sortByDesc('seeded_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->seeded_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>

            <div class="col-md-3">
                <h3 class="text-center">Midwest</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Seeded Score</th>
                </tr>
                @foreach ($midWestTeams->sortByDesc('seeded_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->seeded_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>
            
        </div>

        <div class="col-md-12">
            <h1 class="text-center">Team Grandpa Scores</h1>
            <div class="col-md-3">
                <h3 class="text-center">West</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Grandpa Score</th>
                </tr>
                @foreach ($westTeams->sortByDesc('grandpa_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->grandpa_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>

            <div class="col-md-3">
                <h3 class="text-center">East</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Grandpa Score</th>
                </tr>
                @foreach ($eastTeams->sortByDesc('grandpa_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->grandpa_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>

            <div class="col-md-3">
                <h3 class="text-center">South</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Grandpa Score</th>
                </tr>
                @foreach ($southTeams->sortByDesc('grandpa_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->grandpa_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>

            <div class="col-md-3">
                <h3 class="text-center">Midwest</h3>
                <table class="table table-hover table-bordered">
                <tr>
                    <th>Team</th>
                    <th>Wins</th>
                    <th>Grandpa Score</th>
                </tr>
                @foreach ($midWestTeams->sortByDesc('grandpa_points') as $team)
                <tr> 
                    <td><strong>{{ $team->team_name }}</strong></td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->grandpa_points }}</td>
                </tr>
                @endforeach
            </table>
            </div>
            
        </div>
    </div>
</div>
@endsection
