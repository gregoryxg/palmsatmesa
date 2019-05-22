@extends('layouts.master')

@section('title', 'New Ticket')

@section('active_support', 'active')

@section('active_new_ticket', 'active')

@section('content')

    <div class="container pt-5">

        <form method="post" action="/ticket">
            @csrf

            @if ($errors->has('errors'))
                <div class="alert alert-danger text-center">
                    <span>
                        <strong>{{ $errors->first('errors') }}</strong>
                    </span>
                </div>
            @endif

            @if (\Session::has('success'))
                <div class="alert alert-success text-center">
                    <span>
                        <strong>{{ \Session::get('success') }}</strong>
                    </span>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group required col-md-4">
                    <label for="ticket_type_id" class="control-label">Ticket Type:</label>
                    <select id='ticket_type_id' class='form-control{{ $errors->has('ticket_type_id') ? ' is-invalid' : '' }}' name="ticket_type_id" required><option/>
                        @foreach($ticket_types as $ticket_type)
                            <option value="{{ $ticket_type->id }}" {{ old('ticket_type_id') ? 'selected' : ''}}>{{ $ticket_type->description }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('ticket_type_id'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('ticket_type_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group required col-md-4">
                    <label for="subject" class="control-label">Subject:</label>
                    <input type="text" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject') }}" required>
                    <small>255 Characters Max</small>
                    @if ($errors->has('subject'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group required col-md-4">
                    <label for="body" class="control-label">Description</label>
                    <textarea name="body" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" rows="10" required>{{ old('body') }}</textarea>
                    <small>2000 Characters Max</small>
                    @if ($errors->has('body'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('body') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="row pt-2">
                <div class="col-md-4"></div>
                <div class="form-group col-md-4">
                    <button id='submit_button' type="submit" class="btn btn-secondary">Submit Ticket</button>
                </div>
            </div>

        </form>

    </div>

@endsection
