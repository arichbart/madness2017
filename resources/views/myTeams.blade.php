@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="text-center">My Teams</h1> <br>
            <div class="col-md-6">
                <h3 class="text-center">Grandpa Scoring</h3>
                @if($myGrandpa[0] != null)
                    <ol>
                        <li>{{ $myGrandpa[0]->team1->team_name }} {{ $myGrandpa[0]->team1->seed }}</li>
                        <li>{{ $myGrandpa[0]->team2->team_name }} {{ $myGrandpa[0]->team2->seed }}</li>
                        <li>{{ $myGrandpa[0]->team3->team_name }} {{ $myGrandpa[0]->team3->seed }}</li>
                        <li>{{ $myGrandpa[0]->team4->team_name }} {{ $myGrandpa[0]->team4->seed }}</li>
                    </ol>
                @endIf
            </div>
            <div class="col-md-6">
                <h3 class="text-center">Seeded Scoring</h3>
                @if($mySpecial[0] != null)
                    <ol>
                        <li>{{ $mySpecial[0]->team1->team_name }} {{ $mySpecial[0]->team1->seed }}</li>
                        <li>{{ $mySpecial[0]->team2->team_name }} {{ $mySpecial[0]->team2->seed }}</li>
                        <li>{{ $mySpecial[0]->team3->team_name }} {{ $mySpecial[0]->team3->seed }}</li>
                        <li>{{ $mySpecial[0]->team4->team_name }} {{ $mySpecial[0]->team4->seed }}</li>
                    </ol>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
