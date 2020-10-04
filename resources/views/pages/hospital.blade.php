@extends('layouts.app')

@section('body')
    <div class="container">   
        @if(count($result) > 0)
            @foreach ($result as $item)
                <div class="card">
                    <div class="card-body">
                        <h2>{{$item->name}}</h2>
                        <h6>{{$item->category}}</h6>
                        <h6>{{$item->contact}}</h6>
                    </div>
                </div>
            @endforeach
        @else 
            <h2>No data found.</h2>
        @endif     
    </div>
@endsection