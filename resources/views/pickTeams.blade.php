@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <nav class="navbar navbar-default">
                <a class="navbar-brand" href="/home">Home</a>
                <a class="navbar-brand" href="#">Make Selections</a>
                <a class="navbar-brand" href="/myTeams">My Teams</a>
                <a class="navbar-brand" href="/scoreboard">Scoreboard</a>
                <a class="navbar-brand" href="/best">Best Teams</a>
            </nav>
            <h1 class="text-center">Pick Your Teams</h1> <br>
            <h4 class="text-center col-md-8 col-md-offset-2">If you've already made your selections you can modify them here until the first game starts on Thursday.  Clicking submit at the bottom will overwrite your old picks with your new selections.</h4>
            <h2 class="text-center col-md-12">Grandpa Scoring</h2>
            <legend></legend>
            <div class="text-center col-md-12">
                <strong>Rules:</strong> Select one team from each region.  <u>You can only select one team with a 1 seed.</u>  You can select more than one of every other seed. <br> <br>

                <strong>Scoring:</strong> Each round that your team wins you score 1 point. (This score will be multiplied by 6 for the overall score) <br> <br>

                <strong>Example:</strong> Duke, a number 2 seed, wins in round 1...you recieve 1 point.  They win in round 2...you receive an additional 1 point. etc... <br> <br>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="/myTeams" method="POST">
            {{ csrf_field() }}
                <div class="col-md-6 form-group">
                    <h3 class="text-center">South</h3>
                    <select class="form-control" name="grandpaTL"> 
                        <?php $x=1; ?>
                        @foreach ($topLeft as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                    <br>
                    <h3 class="text-center">West</h3>
                    <select class="form-control" name="grandpaBL"> 
                        <?php $x=17; ?>
                        @foreach ($topRight as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <h3 class="text-center">East</h3>
                    <select class="form-control" name="grandpaTR"> 
                        <?php $x=33; ?>
                        @foreach ($bottomLeft as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                    <br>
                    <h3 class="text-center">Midwest</h3>
                    <select class="form-control" name="grandpaBR"> 
                        <?php $x=49; ?>
                        @foreach ($bottomRight as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <h2 class="text-center">Seeded Scoring</h2>
                    <legend></legend>
                <strong>Rules:</strong> Select one team from each region.  <u>There are no limits as to how many of a certain seed you can select.</u> <br> <br>

                <strong>Scoring:</strong> Each round that your team wins you score points.  Points are earned by multiplying your team's seed by the round they win in. <br> <br>

                <strong>Example:</strong> Duke, a number 2 seed, wins in round 1...you recieve 2 points.  They win in round 2...you receive an additional 4 points.  They win in round 3...you receive an additional 6 points. etc... <br> <br>
                </div>
                <div class="col-md-6 form-group">
                    <h3 class="text-center">South</h3>
                    <select class="form-control" name="specialTL"> 
                        <?php $x=1; ?>
                        @foreach ($topLeft as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                    <br>
                    <h3 class="text-center">West</h3>
                    <select class="form-control" name="specialBL"> 
                        <?php $x=17; ?>
                        @foreach ($topRight as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <h3 class="text-center">East</h3>
                    <select class="form-control" name="specialTR"> 
                        <?php $x=33; ?>
                        @foreach ($bottomLeft as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                    <br>
                    <h3 class="text-center">Midwest</h3>
                    <select class="form-control" name="specialBR"> 
                        <?php $x=49; ?>
                        @foreach ($bottomRight as $team)
                            <option value="{{ $x }}">{{ $team->team_name }} {{ $team->seed }}</option>
                            <?php $x++ ?>
                        @endforeach
                    </select>
                    <br>
                </div> 
                <input type="submit" name="submit" class="btn btn-block btn-primary btn-lg">
            </form>
        </div>
    </div>
</div>
@endsection
