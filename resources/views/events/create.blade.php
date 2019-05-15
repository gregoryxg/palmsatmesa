@extends('layouts.master')

@section('title', 'Create New Event')

@section('active_events', 'nav-item active')

@section('content')
<div class="container pt-5">
    <br/>
    <form method="post" action="/event">
        @csrf
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="title" class="control-label">Title:</label>
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
                <label for="size" class="control-label">Party size including host:</label>
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
                <label for="date" class="control-label">Date:</label>
                <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name='date' required/>
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
                <select id='location' class='form-control{{ $errors->has('location') ? ' is-invalid' : '' }}' name="location" required><option/>
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
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-secondary">Add Event</button>
            </div>
        </div>
    </form>
</div>

@section('page_js')

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
                        data.timeslots.forEach(timeslot => {
                            $("#timeslot").append(new Option(moment(timeslot.start_time, "HH:mm:ss").format("h:mm A") + " - " + moment(timeslot.end_time, "HH:mm:ss").format("h:mm A"), timeslot.id));
                        });

                    }
                })
            }
        });
    </script>

@endsection

@endsection
