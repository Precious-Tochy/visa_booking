@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')
<h3 class="fw-bold mb-0">Flight Booking</h3>
            <p class="text-muted mb-0">Manage and view all flight applications</p>

<div class="container-fluid mt-4">

    {{-- Dashboard Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white shadow-sm">
                <div class="card-body">
                    <h5>Total Bookings</h5>
                    <h2>{{ $bookings->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white shadow-sm">
                <div class="card-body">
                    <h5>Pending</h5>
                    <h2>{{ $bookings->where('status','pending')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white  shadow-sm">
                <div class="card-body">
                    <h5>Confirmed</h5>
                    <h2>{{ $bookings->where('status','confirmed')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-white shadow-sm">
                <div class="card-body">
                    <h5>Cancelled</h5>
                    <h2>{{ $bookings->where('status','cancelled')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Search and Filters --}}
    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <input type="text" class="form-control" id="searchInput" placeholder="Search by Passenger, Email, Phone...">
        </div>
        <div class="col-md-3 mb-2">
            <select id="filterDestination" class="form-select">
                <option value="">All Destinations</option>
                @foreach($bookings->pluck('destination_city')->unique() as $city)
                <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select id="filterStatus" class="form-select">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="col-md-2 mb-2 text-end">
    <a href="{{ route('admin.flight.export') }}" class="btn btn-outline-secondary">
        <i class="ri-file-download-line"></i> Export PDF
    </a>
</div>
<style>
    .btn-outline-secondary {
    border-radius: 8px;
    font-weight: 600;
    padding: 10px 18px;
    transition: 0.3s;
}
.btn-outline-secondary:hover {
    background-color: #114B66;
    color: #fff;
    border-color: #114B66;
}
.card-body h5{
    color: #000;
}
.card-body h2{
    color: #000;
    font-weight: 700;}
    .card-body{
        background-color: #afb1b184;
        border-radius: 12px;
    }
    .card{
        background-color: #ebeeee84;
    }
</style>
    </div>

    {{-- Flight Bookings Table --}}
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle" id="bookingTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Passenger</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Route</th>
                    <th>Departure</th>
                    <th>Passengers</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr data-status="{{ $booking->status }}" data-destination="{{ $booking->destination_city }}">
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                    <td>{{ $booking->email }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->departure_city }} → {{ $booking->destination_city }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->departure_date)->format('d M Y') }}</td>
                    <td>{{ $booking->passengers }}</td>
                    <td>
                        <form action="{{ route('admin.flight.status', $booking->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewBooking{{ $booking->id }}">View</button>
                        <form action="{{ route('admin.flight.delete', $booking->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">
        Delete
    </button>
</form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Booking Detail Modals --}}
@foreach($bookings as $booking)
<div class="modal fade" id="viewBooking{{ $booking->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking #{{ $booking->id }} Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @php
                        $details = [
                            'Passenger Name' => $booking->first_name . ' ' . $booking->last_name,
                            'Email' => $booking->email,
                            'Phone' => $booking->phone,
                            'DOB' => $booking->dob ?? 'N/A',
                            'Passport Number' => $booking->passport_number ?? 'N/A',
                            'Trip Type' => ucfirst($booking->trip_type),
                            'Departure City' => $booking->departure_city,
                            'Destination City' => $booking->destination_city,
                            'Departure Date' => $booking->departure_date,
                            'Return Date' => $booking->return_date ?? 'N/A',
                            'Passengers' => $booking->passengers,
                            'Class' => ucfirst($booking->class),
                            'Preferred Airline' => $booking->airline ?? 'N/A',
                            'Notes' => $booking->notes ?? 'None',
                            'Submitted At' => $booking->created_at->format('d M Y H:i'),
                        ];
                    @endphp

                    @foreach($details as $key => $value)
                    <div class="col-md-6 mb-3">
                        <strong>{{ $key }}</strong>
                        <p>{{ $value }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach

@endsection

{{-- Scripts --}}
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
// Search functionality
const searchInput = document.getElementById('searchInput');
const bookingsTable = document.getElementById('bookingsTable');
searchInput.addEventListener('keyup', function() {
    const filter = searchInput.value.toLowerCase();
    Array.from(bookingsTable.tBodies[0].rows).forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
    });
});

// Filter by destination
const filterDestination = document.getElementById('filterDestination');
filterDestination.addEventListener('change', function() {
    const value = this.value.toLowerCase();
    Array.from(bookingsTable.tBodies[0].rows).forEach(row => {
        row.style.display = (row.dataset.destination.toLowerCase().includes(value)) ? '' : 'none';
    });
});

// Filter by status
const filterStatus = document.getElementById('filterStatus');
filterStatus.addEventListener('change', function() {
    const value = this.value.toLowerCase();
    Array.from(bookingsTable.tBodies[0].rows).forEach(row => {
        row.style.display = (row.dataset.status.toLowerCase().includes(value)) ? '' : 'none';
    });
});

// Export PDF
document.getElementById('exportBtn').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.text("Flight Bookings", 10, 10);
    let y = 20;
    Array.from(bookingsTable.tBodies[0].rows).forEach(row => {
        const rowData = Array.from(row.cells).map(cell => cell.innerText).join(' | ');
        doc.text(rowData, 10, y);
        y += 8;
    });
    doc.save('flight_bookings.pdf');
});

// Delete Booking (simple confirmation, implement backend route)
document.querySelectorAll('.deleteBooking').forEach(btn => {
    btn.addEventListener('click', () => {
        if(confirm("Are you sure you want to delete this booking?")) {
            // Call your delete route here via AJAX or form submit
            alert("Booking deleted (implement backend).");
        }
    });
});
</script>
@push('scripts')
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {

    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("#bookingTable tbody tr");

    rows.forEach(function(row) {

        let text = row.innerText.toLowerCase();

        if (text.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });

});
</script>
@endpush
@endsection

{{-- Responsive CSS --}}
@section('styles')
<style>
.table-responsive {
    overflow-x: auto;
}
@media (max-width: 575px) {
    .table thead { display: none; }
    .table tbody tr { display: block; margin-bottom: 1rem; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px; }
    .table tbody td { display: flex; justify-content: space-between; padding: 5px 10px; border: none; }
    .table tbody td::before { content: attr(data-label); font-weight: 600; }
    .modal-dialog { max-width: 95%; margin: 1.5rem auto; }
    .modal-body p { font-size: 0.9rem; }
}
</style>
@endsection