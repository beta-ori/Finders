@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>
            Welcome to Admin Panel
        </h1>
        <div class="card">
           

            <div class="card-body">
                <a class="btn btn-primary btn-lg" href="/hospital/create">{{ __('Add New Hospital') }}</a>
            </div>
        </div>
    </div>
@endsection