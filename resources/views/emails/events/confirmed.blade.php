<!DOCTYPE html>
<html>
<head>
    <title>Your reservation at The Palms is confirmed</title>
</head>
<body>
<img src='{{ asset(Storage::url('public/logo/ThePalms.png')) }}' width="100"/>
<h2>Reservation Details:</h2>
<br/>Title: {{ $event->title }}
<br/>Party Size: {{ $event->size }}
<br/>Location: {{$event->reservable->description }}
<br/>Date: {{ date('n/d/Y', strtotime($event->date)) }}
<br/>Start Time: {{ date('g:i A', strtotime($event->date . " " . $event->start_time)) }}
<br/>End Time: {{ date('g:i A', strtotime($event->date . " " . $event->end_time)) }}
<br/>Payment Receipt: <a href="{{ $event->stripe_receipt_url }}">{{ $event->stripe_receipt_url }}</a>
<br/>
<br/>You may make changes to this reservation, or cancel it using the reservation system through the Palms <a href="{{route('index')}}">website.</a>
<br/><br/>* This is an unmonitored email account. Any replies to this email will be rejected.
<br>If you believe you received this email by mistake, please submit a ticket through the Palms <a href="{{route('index')}}">website</a> to the Website and Technical Support committee, thank you.
</body>
</html>
