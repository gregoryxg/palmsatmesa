@extends('layouts.master')

@section('title', "Reservation")

@section('active_events', 'active')

@section('active_my_reservations', 'active')

@section('content')
<div class="container pt-5">
    <form method="post" action="/event/{{ $event->id }}">
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
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <div class='form-control border-0 text-center' >
                    * Only the title and number of guests may be edited for existing reservations
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <div class='form-control border-0 text-center' >
                    * Reservations cannot be cancelled within 48 hours of the start time, and processing fees are non-refundable.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="title" class="control-label">Reservation Title:</label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ $event->title }}" required>
                @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="size" class="control-label">Party size including host (max  {{ $event->reservable->guest_limit }}):</label>
                <input type="number" min='1' max='{{ $event->reservable->guest_limit }}' class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" name="size" value="{{ $event->size }}" required/>
                @if ($errors->has('size'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('size') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="date" class="control-label">Date (Must be within the next 30 days):</label>
                <input disabled type="date" class="form-control" name='date' value="{{ $event->date }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime("+30 days")) }}" required/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="reservable_id" class="control-label">Location:</label>
                <select disabled id='reservable_id' class='form-control' name="reservable_id" required>
                        <option value="{{ $event->reservable_id }}">{{ $event->reservable->description }}</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="timeslot_id" class="control-label">Time Slot:</label>
                <select disabled id='timeslot_id' class='form-control{{ $errors->has('timeslot_id') ? ' is-invalid' : '' }}' name="timeslot_id">
                    <option value="{{ $event->timeslot_id }}" selected>{{ date('g:i A', strtotime($event->timeslot->start_time)) . " - " . date('h:i A', strtotime($event->timeslot->end_time)) }}</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 ml-4">
                <input disabled type="checkbox" id="agree_to_terms" name="agree_to_terms" value='1' class="form-check-input" checked required/>
                <label for="agree_to_terms" class="form-check-label control-label">
                    I agree to the reservation <a href="{{ asset('docs/reservation_terms_and_conditions.pdf') }}" onClick="terms_opened()" target="_newtab_{{ date('YmdHis') }}">Terms and Conditions</a>
                    <br/><small>(You must agree to the terms and conditions before continuing)</small>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 ml-4">
                <input disabled type="checkbox" id="esign_consent" name="esign_consent" value='1' class="form-check-input" checked required/>
                <label for="esign_consent" class="form-check-label control-label">
                    I understand that checking the box above constitutes an electronic signature to the terms and conditions.
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group">
                <button id='submit_button' type="submit" class="btn btn-secondary">Update Event</button>
            </div>
        </form>

        <form method="post" action="/event/{{ $event->id }}">
            @csrf
            @method('delete')
            <div class="form-group pl-5">
                <button onclick="return confirm('Are you sure you want to cancel this event?')" id='submit_button' type="submit" class="btn btn-danger">Cancel Event</button>
            </div>
        </form>
</div>
</div>

@endsection
