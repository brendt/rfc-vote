<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }} - Email Verification</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6;">
<h1 style="font-size: 24px; font-weight: bold;"># Hello!</h1>
<p>You have requested to change your email address. Please click the button below to verify your new email:</p>
<a href="{{ $verificationLink }}"
   style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #3490dc; color: #ffffff; text-decoration: none; border-radius: 5px;">Verify
    Email</a>
<p style="margin-top: 20px;">If you did not make this request, you can safely ignore this email.</p>
<p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
