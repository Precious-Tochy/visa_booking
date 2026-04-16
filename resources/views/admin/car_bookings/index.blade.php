@extends('layouts.admin_layout')
@section('content')
@php
    use Illuminate\Support\Str;
    
@endphp
<h3 class="fw-bold mb-0">Car Booking</h3>
            <p class="text-muted mb-0" style="padding-bottom: 1.2rem;">View and manage all bookings.</p>

<!-- Modern Stats Cards -->
<div class="stats-grid">
    <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Bookings</span>
                <h2 class="stat-value">{{ $totalBookings }}</h2>
                <span class="stat-trend">
                    <i class="fas fa-arrow-up"></i> +12%
                </span>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Pending</span>
                <h2 class="stat-value">{{ $pendingCount }}</h2>
                <span class="stat-trend">
                    <i class="fas fa-hourglass-half"></i> Awaiting
                </span>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Confirmed</span>
                <h2 class="stat-value">{{ $confirmedCount }}</h2>
                <span class="stat-trend">
                    <i class="fas fa-check"></i> Ready
                </span>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Completed</span>
                <h2 class="stat-value">{{ $completedCount }}</h2>
                <span class="stat-trend">
                    <i class="fas fa-check-double"></i> Done
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-card">
    <div class="filter-header">
        <div class="filter-title">
            <i class="fas fa-sliders-h"></i>
            <span>Filter Bookings</span>
        </div>
        <span class="result-badge">{{ $bookings->total() }} results</span>
    </div>
    
    <div class="filter-body">
        <form method="GET" action="{{ route('admin.car.bookings') }}" class="filter-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="filter-control">
                        <option value="">All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>From</label>
                    <input type="date" name="from_date" class="filter-control" value="{{ request('from_date') }}">
                </div>
                
                <div class="filter-group">
                    <label>To</label>
                    <input type="date" name="to_date" class="filter-control" value="{{ request('to_date') }}">
                </div>
                
                <div class="filter-group search-group">
                    <label>Search</label>
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Name, email, phone..." value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn-apply">Apply</button>
                    <a href="{{ route('admin.car.bookings') }}" class="btn-clear">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions -->
<div class="bulk-bar">
    <div class="bulk-left">
        <label class="checkbox-label">
            <input type="checkbox" id="selectAll">
            <span>Select All</span>
        </label>
        <span class="selected-count" id="selectedCount">0 selected</span>
    </div>
    <div class="bulk-right">
        <button class="bulk-btn confirm" onclick="bulkAction('confirm')">✓ Confirm</button>
        <button class="bulk-btn cancel" onclick="bulkAction('cancel')">✕ Cancel</button>
        <button class="bulk-btn complete" onclick="bulkAction('complete')">🏁 Complete</button>
        <button class="bulk-btn delete" onclick="bulkAction('delete')">🗑 Delete</button>
        <button class="bulk-btn export" onclick="exportSelected()">📤 Export</button>
    </div>
</div>

<!-- Bookings Table - No Scroll, Optimized Columns -->
<div class="table-wrapper">
    <form method="POST" action="{{ route('admin.car.bookings.bulk') }}" id="bulkActionForm">
        @csrf
        <input type="hidden" name="action" id="bulkAction">
        
        <table class="bookings-table">
            <thead>
                <tr>
                    <th width="30"></th>
                    <th>Ref</th>
                    <th>Customer</th>
                    <th>Car</th>
                    <th>Pickup</th>
                    <th>Return</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                @php
                    $pickup = Carbon\Carbon::parse($booking->pickup_date);
                    $return = Carbon\Carbon::parse($booking->return_date);
                @endphp
                <tr>
                    <td>
                        <input type="checkbox" name="booking_ids[]" value="{{ $booking->id }}" class="booking-checkbox">
                    </td>
                    <td>
                        <span class="ref-badge">#{{ $booking->id }}</span>
                    </td>
                    <td>
                        <div class="customer-info">
                            <div class="customer-avatar" style="background: {{ '#' . substr(md5($booking->name), 0, 6) }}20; color: {{ '#' . substr(md5($booking->name), 0, 6) }}">
                                {{ strtoupper(substr($booking->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="customer-name">{{ Str::limit($booking->name, 15) }}</div>
                                <div class="customer-email">{{ Str::limit($booking->email, 15) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="car-name">{{ $booking->car ? Str::limit($booking->car->name, 12) : 'N/A' }}</span>
                    </td>
                    <td>
                        <div class="date-cell">
                            <span>{{ $pickup->format('d M') }}</span>
                            <small>{{ $booking->pickup_time }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="date-cell">
                            <span>{{ $return->format('d M') }}</span>
                            <small>{{ $pickup->diffInDays($return) ?: 1 }}d</small>
                        </div>
                    </td>
                    <td>
                        <span class="amount">₦{{ number_format($booking->total_price / 1000, 1) }}k</span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
    <div class="action-group">
        <a href="{{ route('admin.car.booking.details', $booking->id) }}" class="action-btn view" title="View">
            <i class="fas fa-eye"></i>
        </a>

        <button type="button" class="action-btn invoice" onclick="viewInvoice({{ $booking->id }})" title="Invoice">
            <i class="fas fa-file-invoice"></i>
        </button>

        <button type="button" class="action-btn delete" onclick="deleteBooking({{ $booking->id }})" title="Delete">
            <i class="fas fa-trash"></i>
        </button>

        <select class="status-select" onchange="quickStatus({{ $booking->id }}, this.value)" title="Change Status">
            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⚪</option>
            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>🟢</option>
            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>✅</option>
            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>🔴</option>
        </select>
    </div>
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h4>No Bookings Found</h4>
                            <a href="{{ route('admin.car.bookings') }}" class="reset-link">Reset Filters</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </form>
</div>

<!-- Pagination -->
<div class="pagination-wrap">
    <div class="pagination-info">
        Showing {{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }}
    </div>
    <div class="pagination-links">
        {{ $bookings->withQueryString()->links() }}
    </div>
</div>

<!-- Hidden Forms -->
<form method="POST" id="statusForm" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="statusInput">
</form>

<form method="POST" id="deleteForm" style="display: none;">
    @csrf
    @method('DELETE')
</form>
<style>
:root {
    --primary: #4361ee;
    --success: #06d6a0;
    --warning: #ffb703;
    --danger: #ef476f;
    --dark: #2b2d42;
    --light: #f8f9fa;
    --border: #e9ecef;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.stat-card {
    border-radius: 12px;
    padding: 15px;
    color: white;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.stat-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.stat-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-details {
    flex: 1;
}

.stat-label {
    font-size: 11px;
    opacity: 0.9;
    display: block;
    margin-bottom: 2px;
}

.stat-value {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 2px 0;
}

.stat-trend {
    font-size: 9px;
    background: rgba(255,255,255,0.2);
    padding: 2px 6px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

/* Filter Card */
.filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    overflow: hidden;
}

.filter-header {
    padding: 12px 15px;
    background: var(--light);
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-title {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    font-size: 13px;
}

.filter-title i {
    color: var(--primary);
    font-size: 12px;
}

.result-badge {
    background: var(--primary);
    color: white;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
}

.filter-body {
    padding: 15px;
}

.filter-row {
    display: flex;
    gap: 10px;
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 120px;
}

.filter-group label {
    display: block;
    font-size: 10px;
    font-weight: 600;
    color: #666;
    margin-bottom: 3px;
    text-transform: uppercase;
}

.filter-control {
    width: 100%;
    padding: 6px 8px;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 12px;
    height: 32px;
}

.search-wrapper {
    position: relative;
}

.search-wrapper i {
    position: absolute;
    left: 8px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 11px;
}

.search-wrapper input {
    width: 100%;
    padding: 6px 8px 6px 25px;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 12px;
    height: 32px;
}

.filter-actions {
    display: flex;
    gap: 6px;
    min-width: 140px;
}

.btn-apply, .btn-clear {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    flex: 1;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-apply {
    background: var(--primary);
    color: white;
    border: none;
}

.btn-clear {
    background: var(--light);
    color: var(--dark);
    border: 1px solid var(--border);
}

/* Bulk Bar */
.bulk-bar {
    background: white;
    border-radius: 8px;
    padding: 10px 15px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid var(--border);
}

.bulk-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    font-size: 12px;
}

.checkbox-label input {
    width: 14px;
    height: 14px;
}

.selected-count {
    font-size: 11px;
    color: #666;
    background: var(--light);
    padding: 3px 8px;
    border-radius: 12px;
}

.bulk-right {
    display: flex;
    gap: 5px;
}

.bulk-btn {
    padding: 5px 10px;
    border: 1px solid var(--border);
    border-radius: 5px;
    background: white;
    font-size: 11px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.bulk-btn.confirm:hover { background: var(--success); color: white; }
.bulk-btn.cancel:hover { background: var(--warning); color: white; }
.bulk-btn.complete:hover { background: var(--primary); color: white; }
.bulk-btn.delete:hover { background: var(--danger); color: white; }
.bulk-btn.export { background: var(--primary); color: white; }

/* Table Wrapper - No Scroll */
.table-wrapper {
    background: white;
    border-radius: 12px;
    border: 1px solid var(--border);
    margin-bottom: 15px;
    overflow: hidden;
}

.bookings-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.bookings-table th {
    padding: 10px 8px;
    background: var(--light);
    font-size: 11px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    text-align: left;
    border-bottom: 2px solid var(--border);
}

.bookings-table td {
    padding: 10px 8px;
    border-bottom: 1px solid var(--border);
    font-size: 12px;
    vertical-align: middle;
}

/* Column Widths */
.bookings-table th:nth-child(1) { width: 30px; }
.bookings-table th:nth-child(2) { width: 50px; }
.bookings-table th:nth-child(3) { width: 180px; }
.bookings-table th:nth-child(4) { width: 100px; }
.bookings-table th:nth-child(5) { width: 80px; }
.bookings-table th:nth-child(6) { width: 80px; }
.bookings-table th:nth-child(7) { width: 70px; }
.bookings-table th:nth-child(8) { width: 60px; }
.bookings-table th:nth-child(9) { width: 100px; }

/* Table Cell Styles */
.ref-badge {
    font-weight: 600;
    color: var(--primary);
    font-size: 11px;
}

.customer-info {
    display: flex;
    align-items: center;
    gap: 8px;
}
.action-btn.delete:hover { background: var(--danger); color: white; }
.customer-avatar {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 12px;
    flex-shrink: 0;
}

.customer-name {
    font-weight: 500;
    font-size: 11px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
}

.customer-email {
    font-size: 9px;
    color: #999;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
}

.car-name {
    font-size: 11px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 90px;
    display: block;
}

.date-cell {
    display: flex;
    flex-direction: column;
}

.date-cell span {
    font-size: 11px;
    font-weight: 500;
}

.date-cell small {
    font-size: 9px;
    color: #999;
}

.amount {
    font-weight: 600;
    color: var(--success);
    font-size: 11px;
}

.status-badge {
    display: inline-block;
    padding: 3px 6px;
    border-radius: 4px;
    font-size: 9px;
    font-weight: 600;
    text-align: center;
    min-width: 40px;
}

.status-pending { background: rgba(255, 183, 3, 0.1); color: var(--warning); }
.status-confirmed { background: rgba(67, 97, 238, 0.1); color: var(--primary); }
.status-completed { background: rgba(6, 214, 160, 0.1); color: var(--success); }
.status-cancelled { background: rgba(239, 71, 111, 0.1); color: var(--danger); }

.action-group {
    display: flex;
    gap: 3px;
    align-items: center;
}

.action-btn {
    width: 24px;
    height: 24px;
    border: none;
    border-radius: 4px;
    background: var(--light);
    color: #666;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 11px;
}

.action-btn.view:hover { background: var(--primary); color: white; }
.action-btn.invoice:hover { background: var(--success); color: white; }

.status-select {
    width: 40px;
    padding: 3px;
    border: 1px solid var(--border);
    border-radius: 4px;
    font-size: 10px;
    background: white;
    cursor: pointer;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px;
}

.empty-state i {
    font-size: 40px;
    color: #ddd;
    margin-bottom: 10px;
}

.empty-state h4 {
    color: var(--dark);
    margin-bottom: 10px;
    font-size: 14px;
}

.reset-link {
    color: var(--primary);
    text-decoration: none;
    font-size: 12px;
}

/* Pagination */
.pagination-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}

.pagination-info {
    font-size: 11px;
    color: #666;
}

.pagination-links {
    display: flex;
    gap: 3px;
}

.pagination-links .pagination {
    display: flex;
    gap: 3px;
    margin: 0;
}

.pagination-links .page-link {
    padding: 4px 8px;
    border: 1px solid var(--border);
    border-radius: 4px;
    color: var(--dark);
    text-decoration: none;
    font-size: 11px;
    background: white;
}

.pagination-links .active .page-link {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        width: 100%;
    }
    
    .filter-actions {
        width: 100%;
    }
    
    .bulk-bar {
        flex-direction: column;
        gap: 8px;
    }
    
    .bulk-right {
        flex-wrap: wrap;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.getElementById('selectAll')?.addEventListener('change', function () {
    document.querySelectorAll('.booking-checkbox').forEach(cb => {
        cb.checked = this.checked;
    });
    updateSelectedCount();
});

document.querySelectorAll('.booking-checkbox').forEach(cb => {
    cb.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const checked = document.querySelectorAll('.booking-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = checked + ' selected';

    const total = document.querySelectorAll('.booking-checkbox').length;
    document.getElementById('selectAll').checked = total > 0 && checked === total;
}

function bulkAction(action) {
    const selected = document.querySelectorAll('.booking-checkbox:checked').length;

    if (selected === 0) {
        alert('Please select at least one booking');
        return;
    }

    if (confirm('Apply ' + action + ' to ' + selected + ' bookings?')) {
        document.getElementById('bulkAction').value = action;
        document.getElementById('bulkActionForm').submit();
    }
}

function quickStatus(id, status) {
    if (confirm('Update booking status?')) {
        const form = document.getElementById('statusForm');
        form.action = "{{ url('/admin/car-booking') }}/" + id + "/status";
        document.getElementById('statusInput').value = status;
        form.submit();
    }
}

function viewInvoice(id) {
    window.open("{{ url('/admin/car-booking') }}/" + id + "/invoice", "_blank");
}

function deleteBooking(id) {
    if (confirm('Delete this booking?')) {
        const form = document.getElementById('deleteForm');
        form.action = "{{ url('/admin/car-booking') }}/" + id;
        form.submit();
    }
}

function exportSelected() {
    const selected = document.querySelectorAll('.booking-checkbox:checked');

    if (selected.length === 0) {
        alert('Select bookings to export');
        return;
    }

    const ids = [];
    selected.forEach(cb => ids.push(cb.value));

    window.location.href = "{{ route('admin.car.bookings.export') }}" + "?ids=" + ids.join(',');
}
</script>
@endsection