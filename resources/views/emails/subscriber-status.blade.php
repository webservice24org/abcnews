<!DOCTYPE html>
<html>
<head>
    <title>Subscription Status</title>
</head>
<body>
    <h2>Hello {{ $subscriber->name }},</h2>
    <p>Your subscription status has been updated.</p>
    <p><strong>Status:</strong> {{ $status }}</p>

    @if($customMessage)
    <p>{{ $customMessage }}</p>
            @elseif($status === 'active')
                <p>Good news! 🎉 Your subscription has been <strong>activated</strong>.</p>
            @else
                <p>Your subscription is <strong>inactive</strong>. We will notify you once it is active.</p>
            @endif

    <p>Thank you,<br>Team</p>
</body>
</html>



