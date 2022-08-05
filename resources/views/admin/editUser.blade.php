@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="/admin/updateUser/{{ $user->id }}" enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <div class="form-group required row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right control-label">{{ __('First Name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ $user->first_name }}" autofocus>

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
                                    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $user->last_name }}" autofocus>

                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="unit_id" class="col-md-4 col-form-label text-md-right">{{ __('Unit Number') }}</label>

                                <div class="col-md-6">
                                    <input id="unit_id" type="number" min="1000" max="1400" class="form-control{{ $errors->has('unit_id') ? ' is-invalid' : '' }}" name="unit_id" value="{{ $user->unit_id }}" autofocus>

                                    @if ($errors->has('unit_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('unit_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="gate_code" class="col-md-4 col-form-label text-md-right">{{ __('Gate Code') }}</label>

                                <div class="col-md-6">
                                    <input id="gate_code" type="number" class="form-control{{ $errors->has('gate_code') ? ' is-invalid' : '' }}" name="gate_code" value="{{ $user->gate_code }}" autofocus>

                                    @if ($errors->has('gate_code'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gate_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="resident_status_id" class="col-md-4 col-form-label text-md-right">{{ __('Resident Type') }}</label>

                                <div class="col-md-6">
                                    <select id="resident_status_id" class="form-control{{ $errors->has('resident_status_id') ? ' is-invalid' : '' }}" name="resident_status_id" autofocus>
                                        <option/>
                                        <option value="1" {{ $user->resident_status_id == 1 ? 'selected' : '' }}>Homeowner</option>
                                        <option value="2" {{ $user->resident_status_id == 2 ? 'selected' : '' }}>Lessee</option>
                                    </select>

                                    @if ($errors->has('resident_status_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('resident_status_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group required row{{ $errors->has('profile_picture') ? ' pb-5' : '' }}">
                                <label for="profile_picture" class="col-md-4 col-form-label text-md-right">{{ __('Profile Picture') }}</label>

                                <div class="col-md-5 custom-file ml-3">
                                    <input id="profile_picture" type="file" onchange="readURL(this);" class="custom-file-input{{ $errors->has('profile_picture') ? ' is-invalid' : '' }}" name="profile_picture" value="{{ old('profile_picture') }}" autofocus>

                                    <label id="file_name" class="custom-file-label overflow-hidden" for="profile_picture">
                                        Select file...
                                    </label>

                                    @if ($errors->has('profile_picture'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('profile_picture') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="profile_preview" class="col-md-4 col-form-label text-md-right">{{ __('File must be less than 10MB, and a .GIF, .JPG, .JPEG, .PNG, or .SVG type.') }}</label>

                                <div class="col-md-3">
                                    <img id="profile_preview" src="{{ asset(Storage::temporaryUrl($user->profile_picture, now()->addMinutes(5))) }}" height="200px" alt="Profile Picture" class="img-rounded img-responsive"/>
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="mobile_phone" class="col-md-4 col-form-label text-md-right control-label">{{ __('Mobile Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="mobile_phone" type="text" class="form-control{{ $errors->has('mobile_phone') ? ' is-invalid' : '' }}" name="mobile_phone" value="{{ $user->mobile_phone }}" required autofocus>

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
                                    <input id="home_phone" type="text" class="form-control{{ $errors->has('home_phone') ? ' is-invalid' : '' }}" name="home_phone" value="{{ $user->home_phone }}" autofocus>

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
                                    <input id="work_phone" type="text" class="form-control{{ $errors->has('work_phone') ? ' is-invalid' : '' }}" name="work_phone" value="{{ $user->work_phone }}" autofocus>

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
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group required row">
                                <div class="col-md-4"></div>
                                <div class="form-group required col-md-4 ml-4">
                                    <input type="checkbox" id="account_approved" name="account_approved" value='1' {{ $user->account_approved ? "checked" : "" }} class="form-check-input{{ $errors->has('account_approved') ? ' is-invalid' : '' }}"/>
                                    <label for="account_approved" class="form-check-label control-label">
                                        Account Approved
                                    </label>
                                    @if ($errors->has('account_approved'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_approved') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group required row">
                                <div class="col-md-4"></div>
                                <div class="form-group required col-md-4 ml-4">
                                    <input type="checkbox" id="board_member" name="board_member" value='1' {{ $user->board_member ? "checked" : "" }} class="form-check-input{{ $errors->has('board_member') ? ' is-invalid' : '' }}"/>
                                    <label for="board_member" class="form-check-label control-label">
                                        Board Member
                                    </label>
                                    @if ($errors->has('board_member'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('board_member') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group required row">
                                <div class="col-md-4"></div>
                                <div class="form-group required col-md-4 ml-4">
                                    <input type="checkbox" id="administrator" name="administrator" value='1' {{ $user->administrator ? "checked" : "" }} class="form-check-input{{ $errors->has('administrator') ? ' is-invalid' : '' }}"/>
                                    <label for="administrator" class="form-check-label control-label">
                                        Administrator
                                    </label>
                                    @if ($errors->has('administrator'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('administrator') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group required row">
                                <div class="col-md-4"></div>
                                <div class="form-group required col-md-4 ml-4">
                                    <input type="checkbox" id="active" name="active" value='1' {{ $user->active ? "checked" : "" }} class="form-check-input{{ $errors->has('active') ? ' is-invalid' : '' }}"/>
                                    <label for="active" class="form-check-label control-label">
                                        Account Active
                                    </label>
                                    @if ($errors->has('active'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('active') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-secondary">
                                        {{ __('Update') }}
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
