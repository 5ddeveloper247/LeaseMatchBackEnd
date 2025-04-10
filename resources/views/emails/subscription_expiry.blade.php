<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Subscription Has Been Renewed</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Hi {{ $user->name }},</h2>

    <p>
        We wanted to let you know that your <strong>{{ $packageName }}</strong> subscription has been successfully renewed.
    </p>

    <p>
        <strong>Renewal Date:</strong> {{ $renewalDate }}<br>
        <strong>Next Billing Date:</strong> {{ $nextBillingDate }}<br>
        <strong>Amount Charged:</strong> {{ $amount }}
    </p>

    <p>
        Your access continues without interruption, and your new expiry date is <strong>{{ $newExpiryDate }}</strong>.
    </p>

    <p>
        If you have any questions or didn’t intend to renew, you can manage your subscription or contact us at 
        <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.
    </p>

    <p>
        Thanks for staying with us!<br>
        – The {{ config('app.name') }} Team
    </p>
</body>
</html>
