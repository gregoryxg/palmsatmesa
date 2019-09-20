@extends('layouts.master')

@section('title', 'Create Reservation')

@section('active_events', 'active')

@section('active_new_reservation', 'active')

@section('content')
<div class="container pt-5">
    <form method="post" action="/validate">
        @csrf

        @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents)
            <div class="form-group pt-2 row">
                <span class='form-control alert-danger text-center' role="alert">
                    <strong>You have reached your maximum reservations. You must delete some, or wait until some have passed.</strong>
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
            <div class='col-md-4'></div>
            <div class='col-md-4'>
                <table class='table text-center'>
                    <thead>
                        <tr><th scope='col' class='text-center border-0'>Reservation Instructions</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><small>Reservations must be scheduled {{ $advanceDays }} days in advance.</small></td></tr>
                        <tr><td><small>Only 1 clubhouse reservation per unit is allowed in a {{ $daysPerEvent }}-day period.</small></td></tr>
                        <tr><td><small>No reservations are allowed beyond {{ $maxRange }} days in the future.</small></td></tr>
                        <tr><td><small>Reservations are for a maximum of {{ $maxEventTime/60 }} hours and must include a {{ $preEventBuffer/60 }}-hour buffer before the start time to allow for setup and cleanup time.</small></td></tr>
                        <tr><td><small>Processing fees are non-refundable.</small></td></tr>
                        <tr><td><small>All clubhouse rules defined in the terms and conditions below must be followed at all times.</small></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 text-center">
                <label for="title" class="control-label font-weight-bold">Reservation Title:</label>
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}" minlength="1" maxlength="50" required>
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
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif type="number" min='1' max='43' class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" name="size" value="{{ old('size') }}" required/>
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
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif id="date" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name='date' value="{{ old('date') }}" min="{{ $min_date }}" @endif max="{{ date('Y-m-d', strtotime("+$maxRange days")) }}" required/>
                <small>Must be within the next {{ $maxRange }} days</small>
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
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif type="time" class="form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}" name="start_time" value="{{ old('start_time') }}" required/>
                <small>{{ $preEventBuffer/60 }}-hour of non-reserved time required before start time</small>
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
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif type="time" class="form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}" name="end_time" value="{{ old('end_time') }}" required/>
                <small>{{ $maxEventTime/60 }}-hour max reservation time</small>
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
                <select id='reservable_id' class='form-control{{ $errors->has('reservable_id') ? ' is-invalid' : '' }}' name="reservable_id" required><option/>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ old('reservable_id') ? 'selected' : ''}}>{{ $location->description }}</option>
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
                <input disabled type="checkbox" id="agree_to_terms" name="agree_to_terms" value='1' class="form-check-input{{ $errors->has('agree_to_terms') ? ' is-invalid' : '' }}" required/>
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
                <input disabled onchange="document.getElementById('submit').disabled=!this.checked;" type="checkbox" id="esign_consent" name="esign_consent" value='1' class="form-check-input{{ $errors->has('esign_consent') ? ' is-invalid' : '' }}" required/>
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
            <div class="form-group col-md-4">
                <button disabled type='submit' id='submit' class='btn btn-primary'>Checkout</button>
            </div>
        </div>
    </form>
</div>

@section('page_js')
    <script>
        $("input[name='agree_to_terms']").change(function() {
            var terms = $("input[name='agree_to_terms']").prop('checked');
            if (!terms)
            {
                $("#esign_consent").prop('checked', false);
                document.getElementById("esign_consent").disabled=true;
                document.getElementById("submit").disabled=true;
            }
            else
            {
                document.getElementById("esign_consent").disabled=false;
            }
        })
    </script>

    <script>
        function terms_opened()
        {
            document.getElementById("agree_to_terms").disabled=false;
        }
    </script>
    <script>
        $("#title").keyup(function(){
            $("#titlecount").text($(this).val().length);
        });
    </script>

@endsection

@endsection
