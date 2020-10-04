@extends('layouts.app')

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <br><br>
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="/doctor/appointment">
                        @csrf

                        <div class="form-group row">
                            <label for="details" class="col-md-4 col-form-label text-md-right">{{ __('Short Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="details" type="details" name="details" class="form-control @error('details') is-invalid @enderror" details="details" value="{{ old('details') }}"  autocomplete="details" autofocus required> </textarea>

                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" id="doctor_id" name="doctor_id" value= "{{ $id }}" >

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
