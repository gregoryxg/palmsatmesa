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
                <input type="text" class="form-control" name="title" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="size" class="control-label">Party size including host:</label>
                <input type="number" min='1' max='30' class="form-control" required/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="date" class="control-label">Date:</label>
                <input type="date" class="form-control" value="" required/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="location" class="control-label">Location:</label>
                <select id='location' class='form-control' name="location" required><option/>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group required col-md-4">
                <label for="timeslot" class="control-label">Time Slot:</label>
                <select id='timeslot' class='form-control' name="timeslot">{{--<option/>--}}
                    {{--@foreach($timeslots[1] as $timeslot)
                        <option value="{{ $timeslot->id }}">
                            {{
                                date('g:i A', strtotime($timeslot->start_time))
                                . " - "
                                . date('g:i A', strtotime($timeslot->end_time))
                            }}
                        </option>
                    @endforeach--}}
                </select>
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
        $('#location').on('change', function() {
            alert( this.value );
            $('#timeslot').empty()
            $.ajax({
                url: `/reservables/${this.value}/timeslots`,
                success: data => {
                    data.timeslots.forEach(timeslot =>
                        $('#timeslot').append(`<option value="${timeslot.id}">${timeslot.start_time}</option>`)
                    )
                }
            })
        })

        /*$('#location').on('change', e => {
            $('#timeslot').empty()
            $.ajax({
                url: `/reservables/${e.value}/timeslots`,
                success: data => {
                    data.timeslots.forEach(timeslot =>
                        $('#timeslot').append(`<option value="${timeslot.id}">${timeslot.start_time}</option>`)
                    )
                }
            })
        })*/
    </script>

@endsection

@endsection
