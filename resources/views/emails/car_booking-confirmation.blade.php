<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; }
        .content { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Confirmed</h1>
    </div>

    <div class="content">
        <p>Hello {{ $booking->name }},</p>
        <p>Your car booking has been confirmed!</p>
        <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
        <p><strong>Car:</strong> {{ $booking->car->name ?? 'N/A' }}</p>
        <p><strong>Pickup Date:</strong> {{ $booking->pickup_date }}</p>
        <p><strong>Return Date:</strong> {{ $booking->return_date }}</p>
        <p>The invoice is attached to this email.</p>
    </div>

    <div class="footer">
        <p>Thank you for choosing our service!</p>
    </div>
</body>
</html>