<!DOCTYPE html>
<html>
<head>
    <title>Booking Status Updated</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; }
        .content { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Status Updated</h1>
    </div>

    <div class="content">
        <p>Hello {{ $booking->name }},</p>
        <p>Your booking status has been updated.</p>
        <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
        <p><strong>Previous Status:</strong> {{ $oldStatus }}</p>
        <p><strong>New Status:</strong> {{ $booking->status }}</p>
    </div>

    <div class="footer">
        <p>Thank you for choosing our service!</p>
    </div>
</body>
</html>