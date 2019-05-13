@extends('layouts.master')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group required row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right control-label">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right control-label">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="unit_id" class="col-md-4 col-form-label text-md-right control-label">{{ __('Unit Number') }}</label>

                            <div class="col-md-6">
                                <input id="unit_id" type="number" min="1000" max="1400" class="form-control{{ $errors->has('unit_id') ? ' is-invalid' : '' }}" name="unit_id" value="{{ old('unit_id') }}" required autofocus>

                                @if ($errors->has('unit_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('unit_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="gate_code" class="col-md-4 col-form-label text-md-right control-label">{{ __('Gate Code') }}</label>

                            <div class="col-md-6">
                                <input id="gate_code" type="number" class="form-control{{ $errors->has('gate_code') ? ' is-invalid' : '' }}" name="gate_code" value="{{ old('gate_code') }}" required autofocus>

                                @if ($errors->has('gate_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gate_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="resident_status_id" class="col-md-4 col-form-label text-md-right control-label">{{ __('Resident Type') }}</label>

                            <div class="col-md-6">
                                <select id="resident_status_id" class="form-control{{ $errors->has('resident_status_id') ? ' is-invalid' : '' }}" name="resident_status_id" value="{{ old('resident_status_id') }}" required autofocus>
                                    <option/>
                                    <option value="1">Resident</option>
                                    <option value="2">Lessee</option>
                                </select>

                                @if ($errors->has('resident_status_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('resident_status_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="profile_picture" class="col-md-4 col-form-label text-md-right control-label">{{ __('Profile Picture') }}</label>

                            <div class="col-md-6">
                                <input id="profile_picture" type="file" onchange="readURL(this);" class="form-control{{ $errors->has('profile_picture') ? ' is-invalid' : '' }}" name="profile_picture" value="{{ old('profile_picture') }}" required autofocus>
                                <img id="profile_preview" src="http://placehold.it/150x200.png" height="200px" alt="Profile Picture" class="img-rounded img-responsive"/>
                                @if ($errors->has('profile_picture'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('profile_picture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="mobile_phone" class="col-md-4 col-form-label text-md-right control-label">{{ __('Mobile Phone') }}</label>

                            <div class="col-md-6">
                                <input id="mobile_phone" type="text" class="form-control{{ $errors->has('mobile_phone') ? ' is-invalid' : '' }}" name="mobile_phone" value="{{ old('mobile_phone') }}" required autofocus>

                                @if ($errors->has('mobile_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="home_phone" class="col-md-4 col-form-label text-md-right">{{ __('Home Phone') }}</label>

                            <div class="col-md-6">
                                <input id="home_phone" type="text" class="form-control{{ $errors->has('home_phone') ? ' is-invalid' : '' }}" name="home_phone" value="{{ old('home_phone') }}" autofocus>

                                @if ($errors->has('home_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('home_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="work_phone" class="col-md-4 col-form-label text-md-right">{{ __('Work Phone') }}</label>

                            <div class="col-md-6">
                                <input id="work_phone" type="text" class="form-control{{ $errors->has('work_phone') ? ' is-invalid' : '' }}" name="work_phone" value="{{ old('work_phone') }}" autofocus>

                                @if ($errors->has('work_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('work_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="email" class="col-md-4 col-form-label text-md-right control-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="password" class="col-md-4 col-form-label text-md-right control-label">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right control-label">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
