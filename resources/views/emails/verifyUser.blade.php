<!DOCTYPE html>
<html>

<head>
    <title>Welcome Email</title>
</head>

<body>
    <h2>Welcome to Wananchi Contracts Management System {{$user['name']}}</h2>
    <br/> Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email address
    <br/>
    <a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email Address</a>
</body>

</html>
