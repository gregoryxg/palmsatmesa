@extends('layouts.master')

@section('title', 'User Search')

@section('active_admin', 'active')

@section('active_users', 'active')

@section('content')

<div class="container pt-5">
    <form method="post" action="/admin/users">
        @csrf

        @if ($errors->has('errors'))
            <div class="form-group pt-2 row">
                <span class='form-control alert-danger text-center' role="alert">
                    <strong>{{ $errors->first('errors') }}</strong>
                </span>
            </div>
        @elseif ($errors->has('date'))
            <div class="form-group pt-2 row">
                    <span class='form-control alert-danger text-center' role="alert">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
            </div>
        @endif

        <div class="form-group row">
            <div class='col-md-4'></div>
            <div class="form-group required col-md-4 font-weight-bold text-center">
                <h1>User Search</h1>
                <label for="search_by" class="control-label">Search By:</label>
                <select id="search_by" name="search_by" class='custom-select{{ $errors->has('search_by') ? ' is-invalid' : '' }}' required><option></option>
                    <option value="email">Email</option>
                    <option value="phone">10 Digit Phone # (numbers only)</option>
                    <option value="unit">4 Digit Unit # (numbers only)</option>
                    <option value="name">Full Name (space between first and last)</option>
                </select>
                @if ($errors->has('search_by'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('search_by') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class='col-md-4'></div>
            <div class="form-group required col-md-4 font-weight-bold text-center">
                <label for="search_val" class="control-label">Search Value:</label>
                <input type='text' id="search_val" name="search_val" class='form-control{{ $errors->has('search_val') ? ' is-invalid' : '' }}' required/>
                @if ($errors->has('search_val'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('search_val') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class='col-md-4'></div>
            <div class="form-group required col-md-4 font-weight-bold text-center">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
</div>

@endsection
