@extends('layouts.admin_layout')

@section('content')


<!-- KPI -->
<div class="cards">
    <div class="card kpi-card">
    <div><h4>Total</h4><p>{{ $totalapplications }}</p></div>
    <div class="kpi-icon total-icon"><i class="ri-file-line"></i></div>
</div>

<div class="card kpi-card">
    <div><h4>Pending</h4><p>{{ $pending }}</p></div>
    <div class="kpi-icon pending-icon"><i class="ri-time-line"></i></div>
</div>

<div class="card kpi-card">
    <div><h4>Approved</h4><p>{{ $approved }}</p></div>
    <div class="kpi-icon approved-icon"><i class="ri-check-line"></i></div>
</div>

<div class="card kpi-card">
    <div><h4>Rejected</h4><p>{{ $rejected }}</p></div>
    <div class="kpi-icon rejected-icon"><i class="ri-close-circle-line"></i></div>
</div>
</div>

<!-- CHART -->
<div class="card mb-3 chart-card">
    <h4>Applications Analytics</h4>
    <canvas id="visaChart"></canvas>
</div>

<!-- FILTERS -->
<form method="GET" class="filters">
    <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}" 
        placeholder="Search name or country..." 
        class="form-control"
    >

    <select name="status" class="form-control">
        <option value="">All Status</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
        <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
    </select>

    <button class="btn btn-primary">Filter</button>
</form>

<!-- TABLE -->
<div class="table-container">
<table>
<thead>
<tr>
<th>Name</th>
<th>Country</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@forelse($applications as $app)
<tr>
<td>
    {{
        $app->name 
        ?? trim(($app->first_name ?? '') . ' ' . ($app->last_name ?? '')) 
        ?: 'N/A'
    }}
</td>

<td>
    {{
        $app->country 
        ?: $app->destination 
        ?: $app->destination_city 
        ?: $app->pickup_location
        ?: $app->location 
        ?: 'N/A'
    }}
</td>
<td>
<span class="badge bg-{{ 
    $app->status == 'approved' ? 'success' : 
    ($app->status == 'pending' ? 'warning' : 'danger') 
}}">
{{ ucfirst($app->status) }}
</span>
</td>
<td>{{ $app->created_at->format('d M Y') }}</td>
<td style="display:flex; gap:5px;">
<button onclick="updateStatus({{ $app->id }}, '{{ $app->type ?? '' }}', 'approved')" class="btn btn-sm btn-success">Approve</button>

<button onclick="updateStatus({{ $app->id }}, '{{ $app->type ?? '' }}', 'rejected')" class="btn btn-sm btn-danger">Reject</button>
</td>
</tr>
@empty
<tr>
<td colspan="5" style="text-align:center;">No applications found</td>
</tr>
@endforelse
</tbody>
</table>



</div>

<style>
:root {
    --primary: #115e82;
    --light: #f4f8fb;
}

body {
    background-color: var(--light);
}
.chart-card {
    background-color: #e8f5fc;
    border-radius: 12px;
    padding: 15px;
}
.kpi-icon {
    padding: 12px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.total-icon{
    background-color: rgb(234, 205, 221) !important;
}
.pending-icon{
    background-color: rgb(244, 239, 170) !important;
}
.approved-icon{
    background-color: rgb(171, 220, 188) !important;
}
.rejected-icon{
    background-color: rgb(226, 183, 184) !important;
}
/* individual icon colors */
.total-icon { background: rgba(17, 94, 130, 0.1); color: #115e82; }
.pending-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
.approved-icon { background: rgba(22, 163, 74, 0.1); color: #16a34a; }
.rejected-icon { background: rgba(220, 38, 38, 0.1); color: #dc2626; }
/* KPI */
.kpi-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 5px solid var(--primary);
     background-color:#c2d6de;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(247, 190, 190, 0.05);
    color: rgb(49, 48, 48);
}

.kpi-icon {
    background: rgba(17,94,130,0.1);
    padding: 8px;
    border-radius: 14px;
}
.kpi-icon i{
    font-weight: bold;
    font-size: 24px;
}

/* Filters */
.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

/* Badge */
.badge {
    padding: 6px 10px;
    border-radius: 8px;
}

.bg-success { background: #16a34a; color: #fff; }
.bg-warning { background: #f59e0b; color: #fff; }
.bg-danger { background: #dc2626; color: #fff; }
</style>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('visaChart'), {
    type: 'line',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Applications',
            data: @json($counts),
            borderColor: '#115e82',
            backgroundColor: 'rgba(17,94,130,0.2)', // 👈 soft fill
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: '#333'
                }
            }
        },
        scales: {
            x: {
                ticks: { color: '#333' }
            },
            y: {
                ticks: { color: '#333' }
            }
        }
    }
});
// AJAX
function updateStatus(id, type, status) {
    fetch("{{ route('admin.update.status') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ 
            id: id, 
            type: type, 
            status: status 
        })
    })
    .then(res => res.json())
    .then(() => location.reload());
}
</script>

@endpush