<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Tour Booking Details</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        h2 { text-align: center; color: #116682; margin-bottom: 20px; font-size: 26px;}
        .logo { text-align: center; margin-bottom: 10px; }
        .logo img { width: 150px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #116682; color: #fff; }
        .status { padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 12px; text-align: center; }
        .pending { background: #ffc107; color: #856404; }
        .approved { background: #28a745; color: #fff; }
        .rejected { background: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <div class="logo">
     <img src="{{ public_path('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Tochy Travels Logo">
    </div>
    <h2>Tour Booking Details</h2>
      
    <table>
        <tr><th>Name</th><td>{{ $booking->first_name }} {{ $booking->last_name }}</td></tr>
        <tr><th>Email</th><td>{{ $booking->email }}</td></tr>
        <tr><th>Phone</th><td>{{ $booking->phone }}</td></tr>
        <tr><th>Country</th><td>{{ $booking->country }}</td></tr>
        <tr><th>Departure Date</th><td>{{ $booking->departure_date }}</td></tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="status 
                    @if($booking->status == 'Approved') approved
                    @elseif($booking->status == 'Rejected') rejected
                    @else pending
                    @endif">
                    {{ $booking->status ?? 'Pending' }}
                </span>
            </td>
        </tr>
    </table>
    <!-- Thank You Footer -->
<footer style="margin-top: 35px; text-align: center; font-family: Arial, sans-serif;">
    <i style="display: block; font-size: 14px; margin-top: 1rem;">
        Thank you for your booking with us! We look forward to giving you an unforgettable experience.
    </i>
    <p style="margin-top: 20px; font-size: 10px; color: #888;">
        &copy; {{ date('Y') }} Tochy Travels. All rights reserved.
    </p>
</footer>
</body>

</html>