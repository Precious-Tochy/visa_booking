<!DOCTYPE html>
<html>
<head>
<style>

body{
font-family: Arial, sans-serif;
}

table{
width:100%;
border-collapse: collapse;
}

table, th, td{
border:1px solid #000;
}

th, td{
padding:8px;
text-align:left;
font-size:12px;
}

th{
background:#116682;
color:white;
}

h2{
text-align:center;
margin-bottom:20px;
}

/* Status badges */

.badge{
display:inline-block;
padding:2px 6px;
border-radius:4px;
color:white;
font-size:11px;
}

.badge-pending{background-color:#ffc107;color:#000;}
.badge-processing{background-color:#17a2b8;}
.badge-approved{background-color:#28a745;}
.badge-rejected{background-color:#dc3545;}

</style>
</head>

<body>

<img src="{{ public_path('visa-booking/image/logo_tochy_travels.jpg') }}"
style="max-width:100px;">

<h2>Visa Applications Report</h2>

<table>

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Visa Type</th>
<th>Country</th>
<th>Occupation</th>
<th>Date</th>
<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($visas as $visa)

<tr>

<td>{{ $visa->id }}</td>

<td>{{ $visa->first_name }} {{ $visa->last_name }}</td>

<td>{{ $visa->email }}</td>

<td>{{ $visa->phone }}</td>

<td>{{ ucfirst($visa->visa_type) }}</td>

<td>{{ $visa->country }}</td>

<td>{{ $visa->occupation }}</td>

<td>{{ $visa->created_at->format('d M Y') }}</td>

<td>

@if($visa->status == 'Pending')

<span class="badge badge-pending">
Pending
</span>

@elseif($visa->status == 'Processing')

<span class="badge badge-processing">
Processing
</span>

@elseif($visa->status == 'Approved')

<span class="badge badge-approved">
Approved
</span>

@else

<span class="badge badge-rejected">
Rejected
</span>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>
<p style="text-align:center;font-size:11px;">
Generated on {{ date('d M Y H:i') }}
</p>
</body>
</html>