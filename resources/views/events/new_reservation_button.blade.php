@if (Auth::user()->resident_status->add_to_calendar)
<div class="panel-heading pb-2">
    <a href="/event/create"><button class="btn btn-outline-primary"><h2><i class="fas fa-plus-square"></i> New Reservation</h2></button></a>
</div>
@endif