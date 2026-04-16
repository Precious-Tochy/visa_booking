@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Visa Applications</h3>
            <p class="text-muted mb-0">Manage and track all visa applications</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.visa.export') }}" class="btn btn-danger">
                Export PDF
            </a>

            <a href="{{ route('admin.visa.export.excel') }}" class="btn btn-success">
                Export Excel
            </a>
        </div>
    </div>

    <!-- ================= STATS ================= -->
    <style>
.stats-card {
    border-radius: 1rem;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: default;
    background-color: rgb(201, 236, 245);
    padding: 3px !important;
    height: 130px;
    

}
.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px #0000001a;
}
.stats-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
.stats-text p {
    font-size: 1.1rem;
    color: #6c757d;
}
.stats-text h4 {
    font-size: 1.5rem;
    font-weight: 700;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #6f42c1, #6610f2);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #0dcaf0, #31d2f2);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #198754, #20c997);
}
</style>

<div class="row g-4 mb-4">
    <!-- Total Applications -->
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="stats-text">
                    <p>Total Applications</p>
                    <h4>{{ $statusStats['total'] }}</h4>
                </div>
                <div class="stats-icon bg-gradient-primary text-white">
                    📋
                </div>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="stats-text">
                    <p>Pending</p>
                    <h4>{{ $statusStats['pending'] }}</h4>
                </div>
                <div class="stats-icon bg-gradient-warning text-white">
                    ⏳
                </div>
            </div>
        </div>
    </div>

    <!-- Processing -->
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="stats-text">
                    <p>Processing</p>
                    <h4>{{ $statusStats['processing'] }}</h4>
                </div>
                <div class="stats-icon bg-gradient-info text-white">
                    ⚙️
                </div>
            </div>
        </div>
    </div>

    <!-- Approved -->
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="stats-text">
                    <p>Approved</p>
                    <h4>{{ $statusStats['approved'] }}</h4>
                </div>
                <div class="stats-icon bg-gradient-success text-white">
                    ✔
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- ================= FILTERS ================= -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Visa Type</label>
                    <select name="visa_type" class="form-select">
                        <option value="">All</option>
                        <option value="tourist">Tourist</option>
                        <option value="study">Study</option>
                        <option value="work">Work</option>
                        <option value="business">Business</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" placeholder="Country">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary w-100">Apply Filter</button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= SEARCH ================= -->
    <div class="card shadow-sm border-0 mb-3" style="background-color: #d6d8d8 !important" >
        <div class="card-body d-flex justify-content-between align-items-center">
            <input
                type="text"
                id="searchInput"
                class="form-control"
                style="width: 38%"
                placeholder="Search name, email, phone....." >
            <span class="text-muted small">
                Showing {{ $visas->count() }} results
            </span>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="visaTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Applicant</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Visa</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visas as $visa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-semibold">{{ $visa->first_name }} {{ $visa->last_name }}</div>
                            <small class="text-muted">Applicant</small>
                        </td>
                        <td>{{ $visa->email }}</td>
                        <td>{{ $visa->phone }}</td>
                        <td><span class="badge bg-primary">{{ ucfirst($visa->visa_type) }}</span></td>
                        <td>{{ $visa->country }}</td>
                        <td>
    <form action="{{ route('admin.visa.update-status', $visa->id) }}" method="POST">
        @csrf
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="Pending" {{ $visa->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Processing" {{ $visa->status == 'Processing' ? 'selected' : '' }}>Processing</option>
            <option value="Approved" {{ $visa->status == 'Approved' ? 'selected' : '' }}>Approved</option>
            <option value="Rejected" {{ $visa->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>
</td>
                        <td class="text-nowrap">
                            <button  style="background-color: #409ec3; color:#fff;"
                                class="btn  btn-sm viewBtn"
                                data-first="{{ $visa->first_name }}"
                                data-last="{{ $visa->last_name }}"
                                data-email="{{ $visa->email }}"
                                data-phone="{{ $visa->phone }}"
                                data-visa="{{ $visa->visa_type }}"
                                data-country="{{ $visa->country }}"
                                data-occupation="{{ $visa->occupation }}"
                                data-consultation="{{ $visa->consultation }}"
                                data-history="{{ $visa->travel_history }}"
                                data-notes="{{ $visa->notes }}"
                                data-stage="{{ $visa->progress_stage }}">
                        
                               View
                            </button>

                            <form action="{{ route('admin.visa.delete',$visa->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button style="background-color: rgb(202, 83, 83); color:#fff; border:none!important; border-radius:4px ; class="btn btn-sm"
                                    onclick="return confirm('Delete this application?') ">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $visas->links() }}
        </div>
    </div>

    <!-- ================= CHARTS ================= -->
    <div class="row g-4 mt-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Visa Status Overview</h6>
                    <canvas id="visaChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Visa Type Distribution</h6>
                    <canvas id="typeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Monthly Applications</h6>
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="visaModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #a2bdc5" >
                <h5>Visa Application Details</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="visaDetails"></div>
                <div class="mt-4">
                    <b>Processing Stage</b>
                    <div class="progress mt-2">
                        <div id="stageBar" class="progress-bar bg-info" style="width:25%">Pending</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= SCRIPTS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// SEARCH
document.getElementById("searchInput").addEventListener("keyup", function(){
    let value = this.value.toLowerCase();
    document.querySelectorAll("#visaTable tbody tr").forEach(row=>{
        row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });
});

// VIEW MODAL
document.addEventListener("click", function(e){
    if(e.target && e.target.classList.contains("viewBtn")){
        let btn = e.target;

        // Fill modal details
        let html = `
            <div class="row g-3">
                <div class="col-md-6"><b>Name:</b> ${btn.dataset.first} ${btn.dataset.last}</div>
                <div class="col-md-6"><b>Email:</b> ${btn.dataset.email}</div>
                <div class="col-md-6"><b>Phone:</b> ${btn.dataset.phone}</div>
                <div class="col-md-6"><b>Visa Type:</b> ${btn.dataset.visa}</div>
                <div class="col-md-6"><b>Country:</b> ${btn.dataset.country}</div>
                <div class="col-md-6"><b>Occupation:</b> ${btn.dataset.occupation}</div>
                <div class="col-md-12"><b>Preferred consultation:</b><br>${btn.dataset.consultation}</div>
                <div class="col-md-12"><b>Travel History:</b><br>${btn.dataset.history}</div>
                <div class="col-md-12"><b>Notes:</b><br>${btn.dataset.notes}</div>
                
            </div>
        `;
        document.getElementById("visaDetails").innerHTML = html;

        // Get current status from dropdown
        let stageDropdown = btn.closest("tr").querySelector(".form-select");
        let stage = stageDropdown.value;

        // Progress bar element
        let stageBar = document.getElementById("stageBar");

        // Set width and color based on stage
        let width = "25%";
        let colorClass = "bg-warning"; // default Pending

        switch(stage){
            case "Pending":
                width = "25%";
                colorClass = "bg-warning";
                break;
            case "Processing":
                width = "50%";
                colorClass = "bg-info";
                break;
            case "Approved":
                width = "100%";
                colorClass = "bg-success";
                break;
            case "Rejected":
                width = "100%";
                colorClass = "bg-danger";
                break;
        }

        stageBar.style.width = width;
        stageBar.innerText = stage;

        // Remove any existing bg-* classes
        stageBar.classList.remove("bg-warning","bg-info","bg-success","bg-danger");
        stageBar.classList.add(colorClass);

        // Show the modal
        new bootstrap.Modal(document.getElementById('visaModal')).show();
    }
});

// CHARTS
new Chart(document.getElementById('visaChart'),{
    type:'bar',
    data:{
        labels:['Pending','Processing','Approved','Rejected'],
        datasets:[{label:'Visa Applications', data:[
            {{ $statusStats['pending'] }},
            {{ $statusStats['processing'] }},
            {{ $statusStats['approved'] }},
            {{ $statusStats['rejected'] }}
        ]}]
    }
});

new Chart(document.getElementById('typeChart'),{
    type:'pie',
    data:{
        labels:['Tourist','Study','Work','Business'],
        datasets:[{data:[
            {{ $typeStats['tourist'] }},
            {{ $typeStats['study'] }},
            {{ $typeStats['work'] }},
            {{ $typeStats['business'] }}
        ]}]
    }
});

new Chart(document.getElementById('monthlyChart'),{
    type:'line',
    data:{
        labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets:[{label:'Applications', data:[
            {{ $monthly[1] ?? 0 }},
            {{ $monthly[2] ?? 0 }},
            {{ $monthly[3] ?? 0 }},
            {{ $monthly[4] ?? 0 }},
            {{ $monthly[5] ?? 0 }},
            {{ $monthly[6] ?? 0 }},
            {{ $monthly[7] ?? 0 }},
            {{ $monthly[8] ?? 0 }},
            {{ $monthly[9] ?? 0 }},
            {{ $monthly[10] ?? 0 }},
            {{ $monthly[11] ?? 0 }},
            {{ $monthly[12] ?? 0 }}
        ]}]
    }
});
</script>

@endsection