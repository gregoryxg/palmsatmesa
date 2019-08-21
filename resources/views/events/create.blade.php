@extends('layouts.master')

@section('title', 'Create Reservation')

@section('active_events', 'active')

@section('active_new_reservation', 'active')

@section('content')
<div class="container pt-5">
    <form method="post" action="/event">
        @csrf
        @if($user->unit->events_in_date_range(0,60)->count() >= 2)
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
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                <strong>New Reservation Instructions</strong>
            </span>
        </div>          
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                * Reservations must be made at least 7 days in advance.
            </span>
        </div>           
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                * Reservations cannot be cancelled within 7 days of the start time.
            </span>
        </div>         
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                * Reservations cannot be made further than 60 days out.
            </span>
        </div>                 
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                * Processing fees are non-refundable.
            </span>
        </div>
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                * {{$user->unit->reservation_limit }} reservation(s) allowed per unit in the next 30 days
            </span>
            <span class="form-control form-control-sm border-0 text-center">(<strong>{{ $user->unit->events_in_date_range(0,29)->count() }} currently scheduled in the next 30 days</strong>)</span>
            <span class="form-control form-control-sm border-0 text-center">(<strong>{{ $user->unit->events_from_today->count() }} currently scheduled in the future</strong>)</span>
        </div>
        <div class="form-group row">
            <span class='form-control border-0 text-center' >
                 * Only 1 reservation per unit per day may be scheduled
            </span>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="title" class="control-label">Reservation Title:</label>
                <input @if($user->unit->events_in_date_range(0,60)->count() >= 2) disabled @endif type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}" minlength="1" maxlength="50" required>
                
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
            <div class="form-group required col-md-4">
                <label for="size" class="control-label">Party size including host:</label>
                @foreach($locations as $location)
                    <br/><small><b>{{ $location->description . " - " . $location->guest_limit . " max"}}</b></small>
                @endforeach               
                <input @if($user->unit->events_in_date_range(0,60)->count() >= 2) disabled @endif type="number" min='1' max='30' class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" name="size" value="{{ old('size') }}" required/>
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
                <label for="date" class="control-label">Date (Must be within the next 60 days):</label>
                <input @if($user->unit->events_in_date_range(0,60)->count() >= 2) disabled @endif id="date" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name='date' value="{{ old('date') }}" @if($user->unit->reservation_limit <= $user->unit->events_in_date_range->count()) min="{{ date('Y-m-d', strtotime('+30 days')) }}" @else min="{{ date('Y-m-d', strtotime('+7 days')) }}" @endif max="{{ date('Y-m-d', strtotime("+60 days")) }}" required/>
                @if ($errors->has('date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="reservable_id" class="control-label">Location:</label>
                @foreach($locations as $location)
                <br/><small><b>{{ $location->description }}</b>
                    <br/>${{ number_format(($location->reservation_fee/100), 2, '.', ' ') . " fee ($" . number_format(($location->security_deposit/100), 2, '.', ' ') . " refundable security deposit)"}}</small>
                @endforeach   
                <select disabled id='reservable_id' class='form-control{{ $errors->has('reservable_id') ? ' is-invalid' : '' }}' name="reservable_id" required><option/>
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
            <div class="form-group required col-md-4">
                <label for="timeslot_id" class="control-label">Time Slot:</label>
                <select disabled id='timeslot_id' class='form-control{{ $errors->has('timeslot_id') ? ' is-invalid' : '' }}' name="timeslot_id">
                </select>
                @if ($errors->has('timeslot_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('timeslot_id') }}</strong>
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
                <input disabled onchange="document.getElementsByClassName('stripe-button-el')[0].disabled=!this.checked;" type="checkbox" id="esign_consent" name="esign_consent" value='1' class="form-check-input{{ $errors->has('esign_consent') ? ' is-invalid' : '' }}" required/>
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
                <b><span id="total"></span></b>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-amount=""
                    data-name="Stripe Payment"
                    data-description="Enter your payment details below"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="usd">
                </script>
                <script>
                    document.getElementsByClassName("stripe-button-el")[0].empty;
                    document.getElementsByClassName("stripe-button-el")[0].disabled=true;
                    // Changes the text of the span tag inside the button                    
                    document.getElementsByClassName("stripe-button-el")[0].childNodes[0].innerHTML="Finish and Pay";
                </script>
            </div>
        </div>
    </form>
</div>

@section('page_js')    
    <script>
        function pay_clicked()
        {
            var mySpans = document.getElementsByTagName('span');

            for(var i=0;i<mySpans.length;i++){
                console.log(mySpans[i].innerHTML);
                if(mySpans[i].innerHTML == 'Pay'){
                    console.log(mySpans[i]);
                    break;
                }
            }
        }
    </script>
    <script>
        $("input[name='agree_to_terms']").change(function() {
            var terms = $("input[name='agree_to_terms']").prop('checked');
            if (!terms)
            {
                $("#esign_consent").prop('checked', false);
                document.getElementById("esign_consent").disabled=true;
                document.getElementsByClassName("stripe-button-el")[0].disabled=true;
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
        $("input[name='size']").change(function() {
            var size = $("input[name='size']").val();
            $('#date').val(null);
            $('#timeslot_id').empty();
            $('#reservable_id').val(null);
            $('#reservable_id').empty();
            document.getElementById("reservable_id").disabled=true;
            $("#esign_consent").prop('checked', false);
            document.getElementsByClassName("stripe-button-el")[0].disabled=true;
            document.getElementById("timeslot_id").disabled=true;
            document.getElementById("total").innerHTML="";
            if (size == "")
            {
                document.getElementById("date").disabled=true;
            }
            else
            {
                document.getElementById("date").disabled=false;                
            }
        })
    </script>
    
    <script>
        $("input[name='date']").change(function() {
            var date = $("input[name='date']").val();
            var size = $("input[name='size']").val();
            var locations = {!! json_encode($locations) !!};
            $('#timeslot_id').empty()
            $('#reservable_id').val(null);
            $('#reservable_id').empty()
            $("#esign_consent").prop('checked', false);
            document.getElementsByClassName("stripe-button-el")[0].disabled=true;
            document.getElementById("timeslot_id").disabled=true;
            document.getElementById("total").innerHTML="";
            if (date == "")
            {
                document.getElementById("reservable_id").disabled=true;
            }
            else
            {
                $.ajax({
                    url: "/reservables/locations",
                    method: 'POST',
                    data: {date: date,
                        user_id: '{{ $user->id }}',
                        _token: $("input[name='_token']").val()},
                    success: function (data) {
                        if (data.result == 1)
                        {
                            document.getElementById("reservable_id").disabled=true;
                            $("#reservable_id").append(new Option("Reservation for unit already exists", null));
                        }
                        else
                        {
                            document.getElementById("reservable_id").disabled = false;
                            $("#reservable_id").append(new Option())

                            for (var i in locations) {
                                if (locations[i].guest_limit >= size)
                                    $("#reservable_id").append(new Option(locations[i].description, locations[i].id));
                            }
                        }
                    }
                })
            }
        })
    </script>

    <script>
        $("select[name='reservable_id']").change(function() {
            var date = $("input[name='date']").val();
            var user_id = '{{ $user->id }}';
            var reservable_id =  this.value;
            var locations = {!! json_encode($locations) !!};
            var token = $("input[name='_token']").val();
            $('#timeslot_id').empty()
            if (reservable_id == "")
            {
                document.getElementById("timeslot_id").disabled=true;
            }
            else
            {
                $.ajax({
                    url: "/reservables/" + reservable_id + "/timeslots",
                    method: 'POST',
                    data: {date: date,
                            user_id: user_id,
                            reservable_id: reservable_id,
                            _token: token},
                    success: function (data) {

                        document.getElementById("timeslot_id").disabled = false;

                        if (data.timeslots.length == 0)
                        {
                            $("#timeslot_id").append(new Option("No timeslots available for that date", null));
                        }
                        else
                        {
                            var fee = 0;
                            var deposit = 0;
                            
                            $("#timeslot_id").append(new Option())
                            
                            for (var i in locations) {
                                if (locations[i].id == reservable_id)
                                    fee = locations[i].reservation_fee
                                    deposit = locations[i].security_deposit
                            }
                            
                            document.getElementById("total").innerHTML="Total Deposit Today: " 
                                    + (deposit/100 + fee/100).toLocaleString("en-US", {style:"currency", currency:"USD"})
                                    + "<br/><small>Reservation Fee: " + (fee/100).toLocaleString("en-US", {style:"currency", currency:"USD"}) + "</small>"
                                    + "<br/><small>(includes " + ((deposit*.029 + fee*.029 + 30)/100).toLocaleString("en-US", {style:"currency", currency:"USD"}) + " of non-refundable processing fees)</small>"
                                    + "<br/><small>Refundable Security Deposit: " + (deposit/100).toLocaleString("en-US", {style:"currency", currency:"USD"}) + "</small>";

                            for (var i in data.timeslots) {
                                $("#timeslot_id").append(new Option(moment(data.timeslots[i].start_time, "HH:mm:ss").format("h:mm A") + " - " + moment(data.timeslots[i].end_time, "HH:mm:ss").format("h:mm A"), data.timeslots[i].id));
                            }
                        }
                    }
                })
            }
        });
    </script>
    <script>
        $("#title").keyup(function(){
            $("#titlecount").text($(this).val().length);
        });
    </script>

@endsection

@endsection
