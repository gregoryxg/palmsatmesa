<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
<img src='{{ asset(Storage::url('public/logo/ThePalms.png')) }}' width="100"/>
<h2>Welcome to the Palms at Mesa {{$user['name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<a href="{{url('user/verify', $user->verify_user->token)}}">Verify Email</a>
<br/><br/>* This is an unmonitored email account. Any replies to this email will be rejected.
<br>If you believe you received this email by mistake, please submit a ticket through the Palms <a href="{{route('index')}}">website</a> to the Website and Technical Support committee, thank you.
</body>
</html>