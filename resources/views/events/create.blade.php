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
                        <tr><th scope='col' class='text-center border-0'>New Reservation Instructions</th></tr>
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
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif id="date" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name='date' value="{{ old('date') }}" @if($user->unit->events_in_date_range(0,$daysPerEvent)->count() >= 1) min="{{ date('Y-m-d', strtotime('+30 days')) }}" @else min="{{ date('Y-m-d', strtotime('+7 days')) }}" @endif max="{{ date('Y-m-d', strtotime("+$maxRange days")) }}" required/>
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
            <div class="form-group required col-md-2 font-weight-bold text-center">
                <label for="start_time" class="control-label">Start Time:</label>
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif type="time" class="form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}" name="start_time" value="{{ old('start_time') }}" required/>
                <small>{{ $preEventBuffer/60 }}-hour of non-reserved time required before start time</small>
                @if ($errors->has('start_time'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('start_time') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group required col-md-2 font-weight-bold text-center">
                <label for="end_time" class="control-label">End Time:</label>
                <input @if($user->unit->events_in_date_range(0,$maxRange)->count() >= $maxEvents) disabled @endif type="time" class="form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}" name="end_time" value="{{ old('end_time') }}" required/>
                <small>{{ $maxEventTime/60 }}-hour max</small>
                @if ($errors->has('start_time'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('start_time') }}</strong>
                    </span>
                @endif
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
        $("input[name='size']").change(function() {
            var size = $("input[name='size']").val();
            $('#date').val(null);
            $('#timeslot_id').empty();
            $('#reservable_id').val(null);
            $('#reservable_id').empty();
            document.getElementById("reservable_id").disabled=true;
            $("#esign_consent").prop('checked', false);
            document.getElementById("submit").disabled=true;
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
            document.getElementById("submit").disabled=true;
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
