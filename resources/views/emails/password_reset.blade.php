<!DOCTYPE html>
<html>
<head>
    <title>You have requested to reset your password</title>
</head>
<body>
<h2>This message is intended for {{ $user['first_name'] . " " . $user['last_name']}}</h2>
<br/>
Please click on the below link to verify your email account:
<br/>
<a href="{{url('password/reset', $user->password_reset->token)}}">Reset Password</a>
</body>
</html>