@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('active_admin', 'active')

@section('active_dashboard', 'active')

@section('content')
<div class="container pt-5">
    <div class="panel panel-default">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <span><strong>{{ \Session::get('success') }}</strong></span>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert-danger">
                <span role="alert"><strong>{{ $errors->first() }}</strong></span>
            </div>
        @endif
        <h1>Admin Dashboard</h1>
        <div class="col-lg-5">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="thead-inverse">
                        <tr>
                            <th colspan="4">
                                New Users
                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Unit</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($new_users as $i=>$user)
                        <tr class='table-row' data-href="/admin/editUser/{{ $user->id }}">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->first_name . " " . $user->last_name }}</td>
                            <td>{{ $user->unit->id }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
