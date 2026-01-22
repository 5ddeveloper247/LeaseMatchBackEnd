<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Trial Expiring Soon</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px;">
    <div style="background-color: #ffffff; border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Free Trial Expiring Soon</h2>
        <p>Dear {{ $user->first_name }},</p>
        
        <p>Your free trial for <strong>{{ $planName }}</strong> is about to expire in <strong>1 day</strong> (expires on {{ $trialEndDate }}).</p>
        
        <p><strong>What happens next?</strong></p>
        <ul>
            <li>If you take no action, your plan will be <strong>automatically upgraded</strong> to a paid subscription.</li>
            <li>You will be charged <strong>£{{ number_format($planPrice, 2) }}</strong> for the next billing cycle.</li>
            <li>You can cancel your subscription at any time before the trial expires to avoid charges.</li>
        </ul>
        
        <div style="margin: 30px 0; text-align: center;">
            <a href="{{ $manageSubscriptionUrl }}" 
               style="background-color: #007bff; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                Manage Subscription
            </a>
        </div>
        
        <p>If you have any questions or need assistance, please don't hesitate to contact our support team at 
            <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.
        </p>
        
        <p>Thank you for trying Lease Match!</p>
        
        <p>Best regards,<br>
        <strong>The Lease Match Team</strong></p>
        
        <div style="margin-top: 30px; font-size: 12px; color: #999; border-top: 1px solid #eee; padding-top: 20px;">
            <p>&copy; {{ date('Y') }} Lease Match. All rights reserved.</p>
            <p>This is an automated notification. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
