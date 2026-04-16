<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: Arial, sans-serif;
}

table {
    width:100%;
    border-collapse: collapse;
}

table, th, td {
    border:1px solid #000;
}

th, td {
    padding:8px;
    text-align:left;
    font-size:12px;
}

th {
    background:#116682;
    color:white;
}

h2 {
    text-align:center;
    margin-bottom:20px;
}

/* Status badges */
.badge {
    display: inline-block;
    padding: 2px 6px;
    border-radius: 4px;
    color: white;
    font-size: 11px;
}

.badge-pending { background-color: #ffc107; color: #000; }
.badge-confirmed { background-color: #28a745; }
.badge-cancelled { background-color: hsl(354, 70%, 54%); }
</style>
</head>
<body>
 <img src="{{ public_path('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Logo" style="display: flex; max-width: 100px;">
<h2>Hotel Reservations Report</h2>

<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Location</th>
<th>Check In</th>
<th>Check Out</th>
<th>Guests</th>
<th>Rooms</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>
<tbody>
@foreach($bookings as $booking)
<tr>
<td>{{ $booking->id }}</td>
<td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
<td>{{ $booking->email }}</td>
<td>{{ $booking->phone }}</td>
<td>{{ $booking->location }}</td>
<td>{{ $booking->check_in->format('d M Y') }}</td>
<td>{{ $booking->check_out->format('d M Y') }}</td>
<td>{{ $booking->guests }}</td>
<td>{{ $booking->rooms }}</td>
<td>{{ $booking->created_at->format('d M Y') }}</td>
<td>
    @if($booking->status == 'pending')
        <span class="badge badge-pending">Pending</span>
    @elseif($booking->status == 'confirmed')
        <span class="badge badge-confirmed">Confirmed</span>
    @elseif($booking->status == 'cancelled')
        <span class="badge badge-cancelled">Cancelled</span>
    @endif
</td>
</tr>
@endforeach
</tbody>
</table>

</body>
</html>