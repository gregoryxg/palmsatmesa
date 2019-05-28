<!DOCTYPE html>
<html>
<head>
    <title>Your reservation at The Palms has been cancelled</title>
</head>
<body>
<h2>Cancelled Reservation Details:</h2>
<br/>Title: <s>{{ $event->title }}</s>
<br/>Party Size: <s>{{ $event->size }}</s>
<br/>Location: <s>{{$event->reservable->description }}</s>
<br/>Date: <s>{{ date('n/d/Y', strtotime($event->date)) }}</s>
<br/>Start Time: <s>{{ date('g:i A', strtotime($event->date . " " . $event->timeslot->start_time)) }}</s>
<br/>End Time: <s>{{ date('g:i A', strtotime($event->date . " " . $event->timeslot->end_time)) }}</s>
<br/>
<br/><br/>* This is an unmonitored email account. Any replies to this email will be rejected.
<br>If you believe you received this email by mistake, please submit a ticket through the Palms <a href="{{route('index')}}">website</a> to the Website and Technical Support committee, thank you.
</body>
</html>