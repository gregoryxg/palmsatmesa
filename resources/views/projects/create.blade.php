@extends('layouts._header')

@section('title', 'Create Project')

@section('content')
    <h1>Create a new Project</h1>
    <form method="post" action="/projects">
        {{csrf_field()}}
        <div>
            <input type="text" name="title" placeholder="Project Title" value="{{old('title')}}" required/>
        </div>
        <div>
            <textarea name="description" placeholder="Project Description" required>{{old('description')}}</textarea>
        </div>
        <div>
            <button type="submit">Create Project</button>
        </div>

        @include('layouts._errors')

    </form>
@endsection
