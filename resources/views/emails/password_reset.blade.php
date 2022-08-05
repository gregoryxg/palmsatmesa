<!DOCTYPE html>
<html>
<head>
    <title>You have requested to reset your password</title>
</head>
<body>
<img src='{{ asset(Storage::url('public/logo/ThePalms.png')) }}' width="100"/>
<h2>This message is intended for {{ $user['first_name'] . " " . $user['last_name']}}</h2>
<br/>
Please click on the below link to verify your email account:
<br/>
<a href="{{url('password/reset', $user->password_reset->token)}}">Reset Password</a>
<br/><br/>* This is an unmonitored email account. Any replies to this email will be rejected.
<br>If you believe you received this email by mistake, please submit a ticket through the Palms <a href="{{route('index')}}">website</a> to the Website and Technical Support committee, thank you.
</body>
</html>