@extends('layouts.master')

@section('title', 'Create Reservation')

@section('active_events', 'active')

@section('active_new_reservation', 'active')

@section('content')
<div class="container pt-5">
    <form method="post" action="/event/{{ $event->id }}">
        @csrf
        @method('patch')

        @if ($errors->has('errors'))
            <div class="form-group pt-2 row">
                <span class='form-control alert-danger text-center' role="alert">
                    <strong>{{ $errors->first('errors') }}</strong>
                </span>
            </div>
        @endif

        @if (\Session::has('success'))
            <div class="form-group pt-2 row">
                <span class='form-control alert-success text-center' role="alert">
                    <strong>{{ \Session::get('success') }}</strong>
                </span>
            </div>
        @endif

        <div class="row">
            <div class='col-md-4'></div>
            <div class='col-md-4'>
                <table class='table text-center'>
                    <thead>
                        <tr><th scope='col' class='text-center border-0'>Update Instructions</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><small>No cancellations are allowed within {{ config('event.noCancellationWindow')/60 }} hours of the start time.</small></td></tr>
                        <tr><td><small>Processing fees are non-refundable.</small></td></tr>
                        <tr><td><small>Only the title and number of guests may be edited for existing reservations.</small></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 text-center">
                <label for="title" class="control-label font-weight-bold">Reservation Title:</label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ $event->title ?? old('title') }}" minlength="1" maxlength="50" required>
                <small><span id="titlecount">0</span> / 50 Characters Max</small>
                @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 text-center">
                <label for="size" class="control-label font-weight-bold">Party size including host:</label>
                @foreach($locations as $location)
                    <br/><small>{{ $location->description . " - " . $location->guest_limit . " max"}}</small>
                @endforeach
                <input type="number" min='1' max='43' class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" name="size" value="{{ $event->size ?? old('size') }}" required/>
                @if ($errors->has('size'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('size') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 font-weight-bold text-center">
                <label for="date" class="control-label">Date:</label>
                <input disabled id="date" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name='date' value="{{ date('Y-m-d', strtotime($event->date)) ?? old('date') }}" required/>
                <small>Must be within the next {{ config('event.maxRange') }} days</small>
                @if ($errors->has('date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 font-weight-bold text-center">
                <label for="start_time" class="control-label">Start Time:</label>
                <select disabled name='start_time' class='form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}' required><option></option>
                    @for ($i=9;$i<21;$i++)
                        <option value='{{ date('g:i A', strtotime($i.":00")) }}' {{ date('g:i A', strtotime($event->start_time)) == date('g:i A', strtotime($i.":00")) ? 'selected' : ''}}>{{ date('g:i A', strtotime($i.":00")) }}</option>
                    @endfor
                </select>
                <small>9am-8pm: {{ config('event.preEventBuffer')/60 }}-hour of unreserved time required before start</small>
                @if ($errors->has('start_time'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('start_time') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 font-weight-bold text-center">
                <label for="end_time" class="control-label">End Time:</label>
                <select disabled name='end_time' class='form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}' required><option></option>
                    @for ($i=10;$i<22;$i++)
                        <option value='{{ date('g:i A', strtotime($i.":00")) }}' {{ date('g:i A', strtotime($event->end_time)) == date('g:i A', strtotime($i.":00")) ? 'selected' : ''}}>{{ date('g:i A', strtotime($i.":00")) }}</option>
                    @endfor
                </select>
                <small>9am-8pm: {{ config('event.preEventBuffer')/60 }}-hour of unreserved time required after end</small>
                @if ($errors->has('end_time'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('end_time') }}</strong>
                    </span>
                @endif
            </div>
        </div>



        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 font-weight-bold text-center">
                <label for="reservable_id" class="control-label">Location:</label>
                @foreach($locations as $location)
                <br/><small><b>{{ $location->description }}</b>
                    <br/>${{ number_format(($location->reservation_fee/100), 2, '.', ' ') . " fee ($" . number_format(($location->security_deposit/100), 2, '.', ' ') . " refundable security deposit, less processing fees of $" . number_format((($location->reservation_fee/100 + $location->security_deposit/100)*.029) +.3, 2, '.', ' ') . ")"}}</small>
                @endforeach
                <select disabled id='reservable_id' class='form-control{{ $errors->has('reservable_id') ? ' is-invalid' : '' }}' name="reservable_id" required><option/>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ $event->reservable_id == $location->id ? 'selected' : ''}}>{{ $location->description }}</option>
                    @endforeach
                </select>
                @if ($errors->has('reservable_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('reservable_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 ml-4">
                <input disabled {{ $event->agree_to_terms == 1 ? 'checked' : 'disabled' }} type="checkbox" id="agree_to_terms" name="agree_to_terms" value='1' class="form-check-input{{ $errors->has('agree_to_terms') ? ' is-invalid' : '' }}" required/>
                <label for="agree_to_terms" class="form-check-label control-label">
                    I agree to the reservation <a href="{{ asset('docs/reservation_terms_and_conditions.pdf') }}" onClick="terms_opened()" target="_newtab_{{ date('YmdHis') }}">Terms and Conditions</a>
                    <br/><small>(You must read the terms and conditions before continuing)</small>
                </label>
                @if ($errors->has('agree_to_terms'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('agree_to_terms') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 ml-4">
                <input disabled {{ $event->esign_consent == 1 ? 'checked' : 'disabled' }} onchange="document.getElementById('submit').disabled=!this.checked;" type="checkbox" id="esign_consent" name="esign_consent" value='1' class="form-check-input{{ $errors->has('esign_consent') ? ' is-invalid' : '' }}" required/>
                <label for="esign_consent" class="form-check-label control-label">
                    I understand that checking the box above constitutes an electronic signature to the terms and conditions.
                </label>
                @if ($errors->has('esign_consent'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('esign_consent') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row pt-2">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4 text-center">
                <button type='submit' id='submit' class='btn btn-primary'>Update</button></form>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="form-group col-md-4 text-center">
                <form method="post" action="/event/{{ $event->id }}">
                    @csrf
                    @method('delete')
                    <button onclick="return confirm('Are you sure you want to cancel this event?')" id='submit_button' type="submit" class="btn btn-large btn-danger">Cancel Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('page_js')
    <script>
        $("#title").keyup(function(){
            $("#titlecount").text($(this).val().length);
        });
    </script>
@endsection

@endsection
