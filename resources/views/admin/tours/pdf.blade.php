<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tour Bookings PDF</title>
    <style>
        /* General */
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        h2 { text-align: center; color: #2c3e43; margin-bottom: 20px; font-size: 1.6rem; }

        /* Logo */
        .logo { text-align: center; margin-bottom: 10px; }
        .logo img { width: 150px; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #116682; color: #fff; }

        /* Status badges */
        .status {
            padding: 4px 10px;
            border-radius: 12px;
            color: #fff;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
        }
        .pending { background: #ffc107; color: #856404; } /* yellow */
        .approved { background: #28a745; color: #fff; } /* green */
        .rejected { background: #dc3545; color: #fff; } /* red */

        /* Optional: row hover for better PDF readability */
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>

    <!-- Logo -->
    <div class="logo">
          <img src="{{ public_path('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Tochy Travels Logo">
    </div>

    <!-- Title -->
    <h2>Guided Tour Bookings</h2>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>Departure Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                <td>{{ $booking->email }}</td>
                <td>{{ $booking->phone }}</td>
                <td>{{ $booking->country }}</td>
                <td>{{ $booking->departure_date }}</td>
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
            @endforeach
        </tbody>
    </table>

</body>
</html>