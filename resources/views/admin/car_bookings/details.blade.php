@extends('layouts.admin_layout')

@section('page-title', 'Booking Details')
@section('page-description', 'View and manage booking information')

@section('content')
<a href="{{route('admin.car.bookings')}}" class="btn btn-light mb-3" style="font-size:1.2rem;">
    &lt;</i> Back
    
</a>
<div class="row">
    <!-- Main Booking Details -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Booking Information</h5>
                <span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="120">Booking Ref:</th>
                                <td><strong class="text-primary">{{ $booking->booking_reference ?? 'CRB'.str_pad($booking->id,6,'0',STR_PAD_LEFT) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Customer:</th>
                                <td>{{ $booking->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $booking->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $booking->phone }}</td>
                            </tr>
                            <tr>
                                <th>Booked On:</th>
                                <td>{{ $booking->created_at->format('F d, Y h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="120">Pickup:</th>
                                <td>{{ Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y') }} at {{ $booking->pickup_time }}</td>
                            </tr>
                            <tr>
                                <th>Location:</th>
                                <td>{{ $booking->pickup_location }}</td>
                            </tr>
                            <tr>
                                <th>Return:</th>
                                <td>{{ Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Duration:</th>
                                <td>{{ $days }} day(s)</td>
                            </tr>
                            <tr>
                                <th>Driver:</th>
                                <td>
                                    @if($booking->with_driver)
                                        <span class="badge bg-info">Yes (+₦10,000)</span>
                                    @else
                                        <span class="badge bg-secondary">Self Drive</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Price Breakdown -->
                <div class="price-breakdown mt-4 p-4 bg-light rounded">
                    <h6 class="mb-3">Price Breakdown</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Car Rental (₦{{ number_format($booking->car->price_per_day) }} × {{ $days }} days)</span>
                        <span>₦{{ number_format($booking->car->price_per_day * $days) }}</span>
                    </div>
                    @if($booking->with_driver)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Driver Service</span>
                        <span>₦10,000</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between fw-bold mt-3 pt-3 border-top">
                        <span>Total Amount</span>
                        <span class="text-primary h5 mb-0">₦{{ number_format($booking->total_price) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Car Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-car me-2"></i>Vehicle Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/'.$booking->car->image) }}" alt="{{ $booking->car->name }}" class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <h4 class="mb-2">{{ $booking->car->name }}</h4>
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <small class="text-muted d-block">Type</small>
                                <strong>{{ $booking->car->type }}</strong>
                            </div>
                            <div class="col-sm-4">
                                <small class="text-muted d-block">Transmission</small>
                                <strong>{{ $booking->car->transmission }}</strong>
                            </div>
                            <div class="col-sm-4">
                                <small class="text-muted d-block">Seats</small>
                                <strong>{{ $booking->car->seats }}</strong>
                            </div>
                        </div>
                        @if($booking->car->location)
                        <div class="mt-2">
                            <small class="text-muted d-block">Location</small>
                            <strong><i class="fas fa-map-marker-alt text-primary me-1"></i>{{ $booking->car->location }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Booking Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Booking Created</h6>
                            <small class="text-muted">{{ $booking->created_at->format('M d, Y h:i A') }}</small>
                        </div>
                    </div>
                    
                    @if($booking->status != 'pending')
                    <div class="timeline-item">
                        <div class="timeline-marker {{ $booking->status == 'confirmed' ? 'bg-primary' : ($booking->status == 'completed' ? 'bg-success' : 'bg-danger') }}"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Status Updated to {{ ucfirst($booking->status) }}</h6>
                            <small class="text-muted">{{ $booking->updated_at->format('M d, Y h:i A') }}</small>
                        </div>
                    </div>
                    @endif
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Pickup Date</h6>
                            <small class="text-muted">{{ Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y') }} at {{ $booking->pickup_time }}</small>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Return Date</h6>
                            <small class="text-muted">{{ Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status Update Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Update Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.car.booking.status', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Booking Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⚪ Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>🟢 Confirmed</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-sync-alt me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Invoice Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Invoice</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.car.booking.invoice.view', $booking->id) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-eye me-2"></i>View Invoice
                    </a>
                    <a href="{{ route('admin.car.booking.invoice.download', $booking->id) }}" class="btn btn-outline-success">
                        <i class="fas fa-download me-2"></i>Download PDF
                    </a>
                    <button class="btn btn-outline-info" onclick="sendInvoice({{ $booking->id }})">
                        <i class="fas fa-envelope me-2"></i>Send to Customer
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $booking->email }}" class="btn btn-outline-secondary">
                        <i class="fas fa-envelope me-2"></i>Email Customer
                    </a>
                    <a href="tel:{{ $booking->phone }}" class="btn btn-outline-secondary">
                        <i class="fas fa-phone me-2"></i>Call Customer
                    </a>
                    <button class="btn btn-outline-warning" onclick="printBooking()">
                        <i class="fas fa-print me-2"></i>Print Details
                    </button>
                    <button class="btn btn-outline-danger" onclick="deleteBooking({{ $booking->id }})">
                        <i class="fas fa-trash me-2"></i>Delete Booking
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Customer Info Card -->
        <div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
    </div>
    <div class="card-body">
        <div class="text-center mb-3">
            <div class="avatar-circle-large bg-primary text-white mx-auto" style="width:80px; height:80px; line-height:80px; font-size:2rem; overflow:hidden; text-overflow:ellipsis;">
                {{ strtoupper(substr($booking->name, 0, 1)) }}
            </div>
            <h5 class="mt-2 text-truncate" style="max-width: 100%;">{{ $booking->name }}</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <tr>
                    <th>Email:</th>
                    <td class="text-truncate" style="max-width: 250px;">{{ $booking->email }}</td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td>{{ $booking->phone }}</td>
                </tr>
                <tr>
                    <th>Total Bookings:</th>
                    <td>{{ \App\Models\CarBooking::where('email', $booking->email)->count() }}</td>
                </tr>
                <tr>
                    <th>Customer Since:</th>
                    <td>{{ $booking->created_at->format('M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 25px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.timeline-content {
    padding-left: 15px;
    border-left: 2px dashed #e0e0e0;
}

.timeline-item:last-child .timeline-content {
    border-left-color: transparent;
}

.avatar-circle-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 600;
}

.badge-pending {
    background: #fff3cd;
    color: #856404;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.badge-confirmed {
    background: #d4edda;
    color: #155724;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.badge-completed {
    background: #cce5ff;
    color: #004085;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.badge-cancelled {
    background: #f8d7da;
    color: #721c24;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.price-breakdown {
    background: #f8fafd;
    border-radius: 12px;
}

.table-borderless th {
    font-weight: 500;
    color: #7f8c8d;
    border: none;
}

.table-borderless td {
    font-weight: 500;
    border: none;
}

.btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning, .btn-outline-danger {
    border-width: 1px;
}
</style>

<script>
function sendInvoice(id) {
    if (confirm('Send invoice to customer email?')) {
        fetch('/admin/car-booking/' + id + '/invoice/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        });
    }
}

function deleteBooking(id) {
    if (confirm('Are you sure you want to delete this booking?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/car-booking/' + id;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function printBooking() {
    window.print();
}

// Auto-hide alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
@endsection