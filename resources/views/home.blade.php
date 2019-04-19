@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"/>
            
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="text-center">
                <img src="http://vignette4.wikia.nocookie.net/logopedia/images/8/84/MarchMadnessLogo.png/revision/latest?cb=20150315225352">
            </div>
        </div>
    </div>
</div>
@endsection
