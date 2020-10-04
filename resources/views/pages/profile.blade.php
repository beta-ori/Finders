@extends('layouts.app')

@section('body')
    <div class="container">

        <div class="card">

            <div class="card-body">
                <h3> {{ Auth::user()->name }}</h3>
                @if(Auth::user()->is_doctor == 1)
                    <h4>{{ Auth::user()->title }}</h6>
                    <h4>{{ Auth::user()->specialities }}</h6>
                @endif
            </div>

        </div>
    </div>
@endsection