<!DOCTYPE html>
<html>
<head>
    <title>Your reservation at The Palms is confirmed</title>
</head>
<body>
<h2>Reservation Details:</h2>
<br/>Title: {{ $event->title }}
<br/>Party Size: {{ $event->size }}
<br/>Location: {{$event->reservable->description }}
<br/>Date: {{ date('n/d/Y', strtotime($event->date)) }}
<br/>Start Time: {{ date('g:i A', strtotime($event->date . " " . $event->timeslot->start_time)) }}
<br/>End Time: {{ date('g:i A', strtotime($event->date . " " . $event->timeslot->end_time)) }}
<br/>
<br/>You may make changes to this reservation, or cancel it using the reservation system through the Palms <a href="{{route('index')}}">website.</a>
<br/><br/>If you did not make this reservation, please submit a ticket through the <a href="{{route('index')}}">website</a> to the Website and Technical Support committee, thank you.
</body>
</html>