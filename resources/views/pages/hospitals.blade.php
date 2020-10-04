@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                @if(count($result) > 0)
                    @foreach ($result as $item)
                        <div class="card">
                            <div class="card-body">
                                <?php
                                    echo '<a href="/hospital?id=';
                                    echo $item->id;
                                    echo '"';
                                ?>
                                <h1 class='title'>{{$item->name}}</h1>
                                </a>
                                <h6>{{$item->category}}</h6>
                                <h6>{{$item->contact}}</h6>
                            </div>
                        </div>
                    @endforeach
                @else 
                    <h2>No data found.</h2>
                @endif
            </div>
        </div>
    </div>
@endsection