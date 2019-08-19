@extends('layouts.master')

@section('title', 'Timeslot')

@section('content')
    <div class="container pt-5">
        <form method="post" action="/admin/timeslots/{{ $timeslot->id }}">
        @csrf
        @method('patch')
        @if (\Session::has('success'))
            <div class="form-group pt-2 row">
                <span class='form-control alert-success text-center' role="alert">
                    <strong>{{ \Session::get('success') }}</strong>
                </span>
            </div>
        @endif
        @if ($errors->has('errors'))
            <div class="form-group pt-2 row">
                <span class='form-control alert-danger text-center' role="alert">
                    <strong>{{ $errors->first('errors') }}</strong>
                </span>
            </div>
        @endif
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                    * All timeslots must be unique (no duplicate start/end time combinations).
            </span>
        </div>  
        
        <div class="form-group row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="start_time" class="control-label">Start Time:</label>
                <input type="time" class="form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}" name="start_time" value="{{ $timeslot->start_time }}" required>
                @if ($errors->has('start_time'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('start_time') }}</strong>
                    </span>
                @endif
            </div>
        </div>  
        
        <div class="form-group row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="end_time" class="control-label">End Time:</label>
                <input type="time" class="form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}" name="end_time" value="{{ $timeslot->end_time }}" required>
                @if ($errors->has('end_time'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('end_time') }}</strong>
                    </span>
                @endif
            </div>
        </div>
                            
        <div class="form-group row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4 ml-4">
                <input type="checkbox" id="active" name="active" value='1' {{ $timeslot->active ? "checked" : "" }} class="form-check-input{{ $errors->has('active') ? ' is-invalid' : '' }}"/>
                <label for="active" class="form-check-label control-label">
                    Timeslot Active
                </label>
                @if ($errors->has('active'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('active') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-md-4"></div>
            <div class="form-group">
                <button id='submit_button' type="submit" class="btn btn-secondary">Update Timeslot</button>
            </div>
        </form>
    </div>
@endsection