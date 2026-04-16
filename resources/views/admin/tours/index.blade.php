@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<div class="tour-wrapper">

    <!-- Header -->
    <div class="header"> 
        <div style="display:flex;flex-direction:column;">
        <h3 class="fw-bold mb-0">Guided Tour Bookings</h3>
            <p class="text-muted mb-0">Manage and view all tour bookings</p>
         </div>



        <div class="header-actions">
            <input type="text" id="searchInput" placeholder="Search bookings...">
            <a href="{{ route('admin.tours.pdf') }}" class="btn-export">Export PDF</a>
        </div>
    </div>

    <!-- Status Filters -->
    <div class="filters">
        <button class="filter-btn active" data-status="all">All</button>
        <button class="filter-btn" data-status="Pending">Pending</button>
        <button class="filter-btn" data-status="Approved">Approved</button>
        <button class="filter-btn" data-status="Rejected">Rejected</button>
    </div>

    <!-- Cards -->
    <div class="card-grid" id="cardGrid">
        @foreach($bookings as $booking)
        <div class="tour-card" data-status="{{ $booking->status ?? 'Pending' }}">
            <div class="card-top">
                <div class="tour-info">
                    <h4>{{ $booking->first_name }} {{ $booking->last_name }}</h4>
                    <p>{{ $booking->email }}</p>
                </div>
                <span class="status 
                    @if($booking->status == 'Approved') approved
                    @elseif($booking->status == 'Rejected') rejected
                    @else pending
                    @endif">
                    {{ $booking->status ?? 'Pending' }}
                </span>
            </div>

            <div class="card-body">
                <p><i class="ri-map-pin-line"></i> {{ $booking->country }}</p>
                <p><i class="ri-calendar-line"></i> {{ $booking->departure_date }}</p>
                <p><i class="ri-mail-line"></i> {{ $booking->phone }}</p>
            </div>

            <div class="card-actions">
    <a href="{{ route('admin.tour.view', $booking->id) }}" title="View Booking">
        <i class="ri-eye-line"></i>
    </a>

    <!-- Download PDF -->
    <a href="{{ route('admin.tour.pdf.single', $booking->id) }}" title="Download PDF">
        <i class="ri-download-line"></i>
    </a>

    <form id="delete-form-{{ $booking->id }}" 
          action="{{ route('admin.tour.delete', $booking->id) }}" 
          method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    <button onclick="confirmDelete({{ $booking->id }})" title="Delete Booking">
        <i class="ri-delete-bin-6-line"></i>
    </button>
</div>
</div>
        @endforeach
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// SUCCESS ALERT
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    confirmButtonColor: '#116682'
});
@endif

// DELETE CONFIRM
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This booking will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#116682',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// SEARCH FUNCTION
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll('.tour-card').forEach(card => {
        let name = card.querySelector('.tour-info h4').innerText.toLowerCase();
        let email = card.querySelector('.tour-info p').innerText.toLowerCase();
        let country = card.querySelector('.card-body p:first-child').innerText.toLowerCase();
        card.style.display = (name.includes(value) || email.includes(value) || country.includes(value)) ? 'block' : 'none';
    });
});

// STATUS FILTER
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let status = this.getAttribute('data-status');

        // Toggle active class
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        // Show/Hide cards
        document.querySelectorAll('.tour-card').forEach(card => {
            let cardStatus = card.getAttribute('data-status');
            card.style.display = (status === 'all' || cardStatus === status) ? 'block' : 'none';
        });
    });
});
</script>



<style>
/* Wrapper */
.tour-wrapper { padding: 30px; background: #f9fafd; }

/* Header */
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header h2 { font-size: 28px; font-weight: 600; color: #116682; }
.header .header-actions { display: flex; gap: 15px; align-items: center; }
.header input { padding: 10px 15px; width: 280px; border-radius: 12px; border: 1px solid #ccc; outline: none; transition: 0.3s; }
.header input:focus { border-color: #116682; box-shadow: 0 0 5px rgba(17,102,130,0.3); }
.btn-export { padding: 10px 18px; border-radius: 8px; background: #116682; color: #fff; text-decoration: none; transition: 0.3s; }
.btn-export:hover { background: #0d4c5d; }

/* Filters */
.filters { margin-bottom: 25px; }
.filter-btn { padding: 8px 20px; border-radius: 25px; border: none; margin-right: 12px; background: #eee; cursor: pointer; font-weight: 500; transition: 0.3s; }
.filter-btn.active, .filter-btn:hover { background: #116682; color: #fff; }

/* Card Grid */
.card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; }

/* Card */
.tour-card { background: #fff; padding: 25px 20px; border-radius: 20px; box-shadow: 0 12px 35px rgba(0,0,0,0.08); transition: 0.3s; }
.tour-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.12); }

/* Card Top */
.card-top { display: flex; justify-content: space-between; align-items: center; }
.tour-info h4 { margin: 0; font-size: 18px; font-weight: 600; color: #333; }
.tour-info p { margin: 3px 0 0 0; font-size: 14px; color: #777; }

/* Status Badge */
.status { padding: 6px 15px; border-radius: 25px; font-size: 13px; font-weight: 500; }
.pending { background: #fff3cd; color: #856404; }
.approved { background: #d4edda; color: #155724; }
.rejected { background: #f8d7da; color: #721c24; }

/* Card Body */
.card-body { margin: 15px 0 20px 0; color: #555; }
.card-body p { margin: 6px 0; display: flex; align-items: center; }
.card-body i { margin-right: 8px; color: #116682; }

/* Card Actions */
.card-actions { display: flex; justify-content: flex-end; gap: 15px; }
.card-actions a, .card-actions button { border: none; background: none; font-size: 20px; cursor: pointer; transition: 0.3s; }
.card-actions a { color: #116682; } .card-actions a:hover { color: #0d4c5d; }
.card-actions button { color: #e63946; } .card-actions button:hover { color: #b02a3b; }
</style>
@endsection