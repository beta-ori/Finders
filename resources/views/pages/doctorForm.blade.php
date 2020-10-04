@extends('layouts.app')

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif  
            <div class="card">
                <div class="card-header">{{ __('Insert new Doctor') }}</div>

                <div class="card-body">
                    <form method="POST" action="/doctor/register">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Doctor Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}"  autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="specialities" class="col-md-4 col-form-label text-md-right">{{ __('specialities') }}</label>

                            <div class="col-md-6">
                                <input id="specialities" type="specialities" class="form-control @error('specialities') is-invalid @enderror" name="specialities" value="{{ old('specialities') }}"  autocomplete="specialities" autofocus>

                                @error('specialities')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="v_hour" class="col-md-4 col-form-label text-md-right">{{ __('Visiting_hour') }}</label>

                            <div class="col-md-6">
                                <input id="v_hour" type="v_hour" class="form-control @error('v_hour') is-invalid @enderror" name="v_hour" value="{{ old('v_hour') }}"  autocomplete="v_hour" autofocus>

                                @error('v_hour')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="v_day" class="col-md-4 col-form-label text-md-right">{{ __('Visiting Day') }}</label>

                            <div class="col-md-6">
                                <input id="v_day" type="v_day" class="form-control @error('v_day') is-invalid @enderror" name="v_day" value="{{ old('v_day') }}"  autocomplete="v_day" autofocus>

                                @error('v_day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hospital_id" class="col-md-4 col-form-label text-md-right">{{ __('Hospital ID') }}</label>

                            <div class="col-md-6">
                                <select id="hospital_id" type="hospital_id" class="form-control @error('hospital_id') is-invalid @enderror" name="hospital_id" value="{{ old('hospital_id') }}"  autocomplete="hospital_id" autofocus>
                                    @foreach ($result as $item)
                                        <option>{{ item.id }}</option>
                                    @endforeach
                                </select>
                                @error('hospital_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
