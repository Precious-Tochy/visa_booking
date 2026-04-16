<!DOCTYPE html>
<html>
<head>
    <title>Flight Bookings</title>
    <style>
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            margin: 20px; 
            color: #333;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
        }

        .header h2 {
            color: #114B66;
            font-size: 28px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            text-align: left;
        }

        th {
            background-color: #114B66;
            color: #fff;
            font-weight: 600;
            font-size: 13px;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        tbody tr:hover {
            background-color: #e0f0ff;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .pending { background-color: #f0ad4e; }
        .confirmed { background-color: #5cb85c; }
        .cancelled { background-color: #d9534f; }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Logo">
    <h2>Flight Bookings Report</h2>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Passenger</th>
            <th>Email</th>
            <th>Phone</th>
            <th>From</th>
            <th>To</th>
            <th>Departure</th>
            <th>Return</th>
            <th>Passengers</th>
            <th>Class</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $b)
        <tr>
            <td>{{ $b->id }}</td>
            <td>{{ $b->first_name }} {{ $b->last_name }}</td>
            <td>{{ $b->email }}</td>
            <td>{{ $b->phone }}</td>
            <td>{{ $b->departure_city }}</td>
            <td>{{ $b->destination_city }}</td>
            <td>{{ \Carbon\Carbon::parse($b->departure_date)->format('d M Y') }}</td>
            <td>{{ $b->return_date ? \Carbon\Carbon::parse($b->return_date)->format('d M Y') : 'N/A' }}</td>
            <td>{{ $b->passengers }}</td>
            <td>{{ ucfirst($b->class) }}</td>
            <td>
                <span class="status-badge {{ strtolower($b->status) }}">
                    {{ ucfirst($b->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Generated on {{ \Carbon\Carbon::now()->format('d M Y H:i') }} | Tochy Travels
</div>
<style>

    table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10px; /* smaller font */
}

th, td {
    padding: 6px 4px; /* smaller padding */
    border: 1px solid #ddd;
    text-align: left;
}
</style>

</body>
</html>