<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #F4F4F4;">
    <div style="max-width: 600px; margin: auto; background-color: #FFFFFF; border: 1px solid #DDDDDD;">
        <div style="background-color: #007BFF; color: white; padding: 20px; text-align: center;">
            <h2 style="max-width: 150px;"> Lease Match Notification</h2>
        </div>
        <div style="padding: 20px;">
            <h2 style="color: #333333;">Password Reset Request</h2>
            <p style="color: #555555;">Dear <strong>{{@$username}}</strong>,</p>
            <p style="color: #555555;">We received a request to reset your password. Use the OTP below to reset your password:</p>
            <p style="text-align: center; margin: 20px 0;">
                <span style="display: inline-block; background-color: #007BFF; color: white; padding: 10px 20px; font-size: 20px; border-radius: 5px;">{{@$otp}}</span>
            </p>
            <p style="color: #555555;">If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>
            <p style="color: #555555;">Best regards,<br>Admin Team</p>
        </div>
        <div style="background-color: #F4F4F4; padding: 10px; text-align: center; color: #999999;">
            &copy; 2024 YourWebsite.com. All rights reserved.
        </div>
    </div>
</body>
</html>
