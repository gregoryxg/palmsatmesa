<!DOCTYPE html>
<html>
<head>
    <title>Ticket # {{ $ticket->id }} - {{ $ticket->subject }}</title>
</head>
<body>
<img src='{{ asset(Storage::url('public/logo/ThePalms.png')) }}' width="100"/>
<h2>Ticket Description:</h2>
{{ $ticket->body }}
<br/><br/>Please allow up to 1 business day for a response, thank you.


<br/><br/>* This is an unmonitored email account. Any replies to this email will be rejected.
<br>If you believe you received this email by mistake, please submit a ticket through the Palms <a href="{{route('index')}}">website</a> to the Website and Technical Support committee, thank you.
</body>
</html>