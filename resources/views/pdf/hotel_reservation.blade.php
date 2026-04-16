<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hotel Reservation</title>
    <style>
        /* Base */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .header h2 {
            color: #116682;
            margin-bottom: 5px;
            font-size: 28px;
        }
        .header p {
            font-size: 16px;
            color: #555;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #116682;
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #116682;
            color: #fff;
            font-weight: 600;
        }
        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        /* Status badge */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 12px;
            color: #fff;
        }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-confirmed { background-color: #28a745; }
        .badge-cancelled { background-color: #dc3545; }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .footer p {
            margin: 5px 0;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Replace with your logo path -->
            <img src="{{ public_path('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Tochy Travels Logo">
            <h2>Hotel Reservation Confirmation</h2>
            <p>Thank you for booking with <strong>Tochy Travels</strong>!</p>
        </div>

        <table>
            <tr><th>Guest</th><td>{{ $booking->first_name }} {{ $booking->last_name }}</td></tr>
            <tr><th>Location</th><td>{{ $booking->location }}</td></tr>
            <tr><th>Hotel Category</th><td>{{ $booking->hotel_category }}</td></tr>
            <tr><th>Check-in</th><td>{{ $booking->check_in }}</td></tr>
            <tr><th>Check-out</th><td>{{ $booking->check_out }}</td></tr>
            <tr><th>Guests</th><td>{{ $booking->guests }}</td></tr>
            <tr><th>Rooms</th><td>{{ $booking->rooms }}</td></tr>
            <tr><th>Room Type</th><td>{{ $booking->room_type ?? 'N/A' }}</td></tr>
            <tr><th>Preferred Hotel</th><td>{{ $booking->preferred_hotel ?? 'N/A' }}</td></tr>
            <tr><th>Notes</th><td>{{ $booking->notes ?? 'None' }}</td></tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($booking->status == 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @elseif($booking->status == 'confirmed')
                        <span class="badge badge-confirmed">Confirmed</span>
                    @elseif($booking->status == 'cancelled')
                        <span class="badge badge-cancelled">Cancelled</span>
                    @else
                        <span class="badge badge-pending">Pending</span>
                    @endif
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>We look forward to hosting you!</p>
            <p>Contact us: (+234) 905 353 1176 | Plot 140 Unity Estate 3-3 Onitsha, Anambra</p>
            <p>www.tochytravels.com</p>
        </div>
    </div>
</body>
</html>