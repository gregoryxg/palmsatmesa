@extends('layouts.master')

@section('title', 'User')

@section('content')

    <div class="container pt-5">
        <div class="row w-50 mx-auto">
            <div class="mx-auto">
                <img src="{{ asset($user->profile_picture) }}" height="200px" alt="http://placehold.it/150x200" class="img-rounded img-responsive">
            </div>
            <div class="mx-auto">
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
                    <i class="fas fa-phone"></i>{{ "Home # " . ($user->home_phone ?? "N/A") }}
                    <br>
                    <i class="fas fa-phone-square"></i>{{ "Home # " . ($user->work_phone ?? "N/A") }}
                </p>
            </div>
            <div class="mx-auto">
                <a href="/user/{{$user->id}}/edit"><button class="btn btn-primary">Edit</button></a>
            </div>
        </div>
    </div>

@endsection
