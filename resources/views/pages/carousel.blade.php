<div id="palmsCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach ($carousel as $i=>$image)
            @if ($i == 0)
                <div class="carousel-item active">
            @else
                <div class="carousel-item">
            @endif
                <svg class="bd-placeholder-img" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" width="100%" height="100%">
                    <image xlink:href="{{ asset(Storage::url($image)) }}" width="100%" height="100%"/>
                </svg>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#palmsCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#palmsCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>