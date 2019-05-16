@extends('layouts.master')

@section('title', 'Create Reservation')

@section('active_events', 'nav-item active')

@section('content')
<div class="container pt-5">
    <br/>
    <form method="post" action="/event">
        @csrf
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="title" class="control-label">Reservation Title:</label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" required>
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
                <label for="size" class="control-label">Party size including host (max 30):</label>
                <input type="number" min='1' max='30' class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" name="size" required/>
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
                <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name='date' min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime("+60 days")) }}" required/>
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
                <label for="location" class="control-label">Location:</label>
                <select disabled id='location' class='form-control{{ $errors->has('location') ? ' is-invalid' : '' }}' name="location" required><option/>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->description }}</option>
                    @endforeach
                </select>
                @if ($errors->has('location'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="timeslot" class="control-label">Time Slot:</label>
                <select disabled id='timeslot' class='form-control{{ $errors->has('timeslot') ? ' is-invalid' : '' }}' name="timeslot">
                </select>
                @if ($errors->has('timeslot'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('timeslot') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4 ml-4">
                <input disabled type="checkbox" id="agree_to_terms" name="agree_to_terms" class="form-check-input" required/>
                <label for="agree_to_terms" class="form-check-label control-label">
                    I agree to the reservation <a href="{{ asset('docs/reservation_terms_and_conditions.pdf') }}" onClick="terms_opened()" target="_newtab">Terms and Conditions</a>
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
                <input disabled type="checkbox" id="esign_consent" name="esign_consent" class="form-check-input" required/>
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
                <button type="submit" class="btn btn-secondary">Add Event</button>
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
        $("input[name='date']").change(function() {
            var date = $("input[name='date']").val();
            $('#timeslot').empty()
            document.getElementById("timeslot").disabled=true;
            if (date == "")
            {
                $('#location').val(null);
                document.getElementById("location").disabled=true;
            }
            else
            {
                document.getElementById("location").disabled=false;
            }
        })
    </script>

    <script>
        $("select[name='location']").change(function() {
            var date = $("input[name='date']").val();
            var reservable_id =  this.value;
            var token = $("input[name='_token']").val();
            $('#timeslot').empty()
            if (reservable_id == "")
            {
                document.getElementById("timeslot").disabled=true;
            }
            else
            {
                $.ajax({
                    url: "/reservables/" + reservable_id + "/timeslots",
                    method: 'POST',
                    data: {date: date,
                            reservable_id: reservable_id,
                            _token: token},
                    success: function (data) {

                        document.getElementById("timeslot").disabled = false;

                        $("#timeslot").append(new Option())

                        for (var i in data.timeslots) {
                            $("#timeslot").append(new Option(moment(data.timeslots[i].start_time, "HH:mm:ss").format("h:mm A") + " - " + moment(data.timeslots[i].end_time, "HH:mm:ss").format("h:mm A"), data.timeslots[i].id));
                        }
                    }
                })
            }
        });
    </script>

@endsection

@endsection
