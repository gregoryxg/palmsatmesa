@extends('layouts.master')

@section('title', 'Home')

@section('active_home', 'nav-item active')

@section('content')

@include('pages.carousel')

        <div class="container marketing">
            <!-- Three columns of text below the carousel -->
            <div class="row">
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><image xlink:href="{{ asset("img/palms_at_mesa_about.jpg") }}" width="100%" height="100%"/></svg>
                    <h2>About</h2>
                    <p>The Palms is a D.R. Horton gated community at 1367 South Country Club Drive, Mesa. Our triplex homes will have floor plans ranging from 1447sf - 1960sf with 3-4 bedrooms, 2.5 – 3.5 bathrooms and 2 car finished garages. All this adds to very affordable maintenance free living.</p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><image xlink:href="{{ asset("img/palms_at_mesa_ammenities.jpg") }}" width="100%" height="100%"/></svg>
                    <h2>Ammenities</h2>
                    <p>The Palms features a 7,000+ sq. ft. club house that has a movie theatre, a pool table room, a gourmet kitchen, great room, and a full workout gym. The grounds of the club house have several gas grills areas for cook outs, two huge heated swimming pools, two in ground spas, and two playground areas. </p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><image xlink:href="{{ asset("img/palms_at_mesa_proximity.jpg") }}" width="100%" height="100%"/></svg>
                    <h2>Proximity</h2>
                    <p>Beautiful resort style living with a great location in Mesa, and only about 19 miles east of downtown Phoenix. This professionally managed gated community is located ½ mile off US 60, 1 mile from the West Mesa Park and Ride, 2 miles from the light rail, 4 miles from Loop 101, Downtown Mesa and the Loop 202.</p>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
@endsection