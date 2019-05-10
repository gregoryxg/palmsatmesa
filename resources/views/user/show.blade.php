@extends('layouts.master')

@section('title', 'User')

@section('content')

    <div class="container pt-5">
        <div class="row">
            <div class="col-6 bg-light">
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive">
                        </div>

                        <div class="col-lg-8">
                            <h4>{{$user->first_name . " " . $user->last_name}}</h4>
                            <p>
                                <i class="fas fa-home">{{ "Unit # " . $user->unit_id . " (" . $user->resident_status->status . ")"}}</i>
                                <br/>
                                <i class="fas fa-keyboard">{{ "Gate Code # " . $user->gate_code }}</i>
                                <br>
                                <i class="fas fa-envelope"></i>{{ "Email: " . $user->email }}
                                <br>
                                <i class="fas fa-mobile-alt"></i>{{ "Mobile # " . $user->mobile_phone }}
                                <br>
                                <i class="fas fa-phone"></i>{{ "Home # " . $user->home_phone }}
                                <br>
                                <i class="fas fa-phone-square"></i>{{ "Home # " . $user->work_phone }}
                            </p>
                            <a href="/user/{{$user->id}}/edit"><button class="btn btn-primary">Edit</button></a>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection
