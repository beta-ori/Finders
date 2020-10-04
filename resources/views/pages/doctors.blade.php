@extends('layouts.app')

@section('body')
    <div class="container">   
        <div class="card">
            <div class="card-header">{{ __('Doctors') }}</div>

            <div class="card-body">
                <form method="POST" action="/doctors">
                    @csrf
                    <div class="form-group row">
                        <label for="specialities" class="col-md-3 col-form-label text-md-right">{{ __('specialities') }}</label>

                        <div class="col-md-6">
                            <input id="specialities" type="specialities" class="form-control @error('specialities') is-invalid @enderror" name="specialities" value="{{ old('specialities') }}" required autocomplete="specialities" autofocus>

                            @error('specialities')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col mx-auto">
                @if(count($data) > 0)
                @foreach ($data as $item)
                <div class="card">
                    <div class="card-body">
                        <h1 class='title'>{{$item->name}}</h1>
                        <h6>{{$item->title}}</h6>
                        <h6>{{$item->specialities}}</h6>
                        <h6>{{$item->v_hour}} kkkkkk</h6>
                        <?php
                            echo '<a href="/doctor/appointment?id=';
                            echo $item->id;
                            echo '"';
                        ?>
                        <h1>Make an appointment</h1>
                        </a>
                        <br>
                        <?php
                            echo '<a href="/hospital?id=';
                            echo $item->id;
                            echo '"';
                        ?>
                        <h1>Map</h1>
                        </a>
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