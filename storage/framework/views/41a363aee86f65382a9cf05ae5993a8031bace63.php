<!DOCTYPE html>
<html>

<head>
    <title>Welcome Email</title>
</head>

<body>
    <h2><?php echo e($user['name']); ?> Welcome to Wananchi Legal System</h2>
    <br/> Your registered email-id is <?php echo e($user['email']); ?> , Please click on the below link to verify your email address
    <br/>
    <a href="<?php echo e(url('user/verify', $user->verifyUser->token)); ?>">Verify Email Address</a>
</body>

</html>
