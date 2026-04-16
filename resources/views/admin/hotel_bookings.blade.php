@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<div class="container mt-2">

    <!-- Header + PDF Download -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
        <div class="display:flex;flex-direction:column;">
        <h3 class="fw-bold mb-0">Hotel Reservations</h3>
            <p class="text-muted mb-0">Manage and view all hotel applications.</p></div>

        <a href="{{ route('admin.hotel.export') }}" class="btn btn-success">
            <i class="fas fa-download me-1"></i> Export All PDF
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 text-center p-3 card-hover" style="background-color: #d5e1e4">
                <h6 class="text-muted">Total Reservations</h6>
                <h2 class="fw-bold">{{ $totalBookings }}</h2>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 text-center p-3 card-hover" style="background-color: #d5e1e4">
                <h6 class="text-muted">Today's Reservations</h6>
                <h2 class="fw-bold">{{ $todayBookings }}</h2>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 text-center p-3 card-hover" style="background-color: #d5e1e4">
                <h6 class="text-muted">This Month</h6>
                <h2 class="fw-bold">{{ $monthlyBookings }}</h2>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.hotel.bookings') }}" class="row mb-3 g-2 align-items-center">
        <div class="col-md-3 col-12">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, email, phone">
        </div>
        <div class="col-md-2 col-12">
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        </div>
        <div class="col-md-2 col-12">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
        </div>
        <div class="col-md-2 col-12">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search me-1"></i> Filter
            </button>
        </div>
    </form>

    <!-- Reservations Table -->
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                    <td>{{ $booking->email }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->location }}</td>
                    <td>{{ $booking->check_in->format('d M Y') }}</td>
                    <td>{{ $booking->check_out->format('d M Y') }}</td>
                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ route('admin.hotel.update.status', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm select-status">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="text-center">
                        <!-- View Modal Trigger -->
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#viewBooking{{ $booking->id }}">
                            <i class="fas fa-eye"></i>
                        </button>

                        <form action="{{ route('admin.hotel.delete',$booking->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Delete this reservation?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>

                        <a href="{{ route('hotel.download.pdf',$booking->id) }}" class="btn btn-success btn-sm mb-1">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>

                <!-- Modal -->
                <!-- Modal -->
<div class="modal fade" id="viewBooking{{ $booking->id }}" tabindex="-1" aria-labelledby="viewBookingLabel{{ $booking->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #a2bdc5">
                <h5 class="modal-title" id="viewBookingLabel{{ $booking->id }}">Reservation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div><strong>Guest Name:</strong> {{ $booking->first_name }} {{ $booking->last_name }}</div>
                        <div><strong>Email:</strong> {{ $booking->email }}</div>
                        <div><strong>Phone:</strong> {{ $booking->phone }}</div>
                        <div><strong>Location:</strong> {{ $booking->location }}</div>
                        <div><strong>Hotel Category:</strong> {{ $booking->hotel_category }}</div>
                        <div><strong>Check-in:</strong> {{ $booking->check_in->format('d M Y') }}</div>
                        <div><strong>Check-out:</strong> {{ $booking->check_out->format('d M Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <div><strong>Guests:</strong> {{ $booking->guests }}</div>
                        <div><strong>Rooms:</strong> {{ $booking->rooms }}</div>
                        <div><strong>Room Type:</strong> {{ $booking->room_type ?? 'N/A' }}</div>
                        <div><strong>Status:</strong> {{ ucfirst($booking->status) }}</div>
                        <div><strong>Booked On:</strong> {{ $booking->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="col-12">
                        <div><strong>Special Requests:</strong> {{ $booking->notes ?? 'None' }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
                    

                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">No reservations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@section('styles')
<style>
/* Cards hover effect */
.card-hover {
    border-radius: 12px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

/* Table hover */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

/* Status select colors */
.select-status option[value="pending"] { color: #000; }
.select-status option[value="confirmed"] { color: #000; }
.select-status option[value="cancelled"] { color: #000; }

/* Responsive tweaks */
@media (max-width: 768px) {
    .table th, .table td { font-size: 0.85rem; padding: 0.5rem; }
    .btn { font-size: 0.75rem; padding: 0.25rem 0.5rem; }
}
</style>
@endsection