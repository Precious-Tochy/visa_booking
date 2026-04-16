@extends('layouts.admin_layout')
@section('page-title', 'Clients')
@section('content')
@php
    $displayName = $clients['summary']['name'] ?? 'Client';

    // Get only the first letter
    $initial = strtoupper(substr(trim($displayName), 0, 1));

    // Generate consistent color from name
    $colors = [
        '#0d6efd', '#6610f2', '#6f42c1', '#d63384',
        '#dc3545', '#fd7e14', '#ffc107', '#198754',
        '#20c997', '#0dcaf0'
    ];

    $colorIndex = abs(crc32($displayName)) % count($colors);
    $bgColor = $colors[$colorIndex];
@endphp


@php
    $name = null;
    $email = null;

    foreach(['flight_bookings','hotel_bookings','car_bookings','tour_bookings','visa_requests'] as $type) {
        if(isset($clients[$type]) && count($clients[$type]) > 0) {
            $first = (array) $clients[$type][0];

            if(!empty($first['name'])) {
                $name = $first['name'];
            } else {
                $firstName = $first['first_name'] ?? '';
                $lastName  = $first['last_name'] ?? '';
                $name = trim($firstName . ' ' . $lastName);
            }

            $email = $first['email'] ?? null;

            if($name || $email) break;
        }
    }

    // ✅ ADD THIS
    $totalBookings = 0;
    foreach(['flight_bookings','hotel_bookings','car_bookings','tour_bookings','visa_requests'] as $type) {
        if(isset($clients[$type])) {
            $totalBookings += count($clients[$type]);
        }
    }
@endphp
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Client Details: {{ $clients['summary']['name'] ?? $phone }}</h3>
        <a href="{{ route('admin.clients') }}" class="btn btn-outline-secondary">Back to Clients</a>
    </div>

    {{-- Client Summary Card --}}
    <div class="card shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">

        {{-- LEFT SIDE --}}
        <div class="d-flex align-items-center gap-3">

            {{-- Avatar --}}
            <div style="
    width:60px;
    height:60px;
    border-radius:50%;
    background: {{ $bgColor }};
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    font-size:20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
">
    {{ $initial }}
</div>

            {{-- Info --}}
            <div>
                
                <p class="mb-0"><strong>Email:</strong> {{ $email ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Phone:</strong> {{ $clients['summary']['phone'] ?? $phone }}</p>

                {{-- Last Booking --}}
                <small class="text-muted">
                    Last Booking:
                    @if(!empty($clients['last_booking_date']))
                        {{ \Carbon\Carbon::parse($clients['last_booking_date'])->diffForHumans() }}
                    @else
                        No bookings yet
                    @endif
                </small>
            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div class="text-end">
            <span class="badge bg-primary fs-6 d-block mb-2">
                Total Bookings: {{ $totalBookings }}
            </span>

            <a href="{{ route('admin.clients.edit', $clients['summary']['phone']) }}" class="btn btn-warning btn-sm">
                Edit Client
            </a>
        </div>

    </div>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title">Recent Activity</h5>

        @if(!empty($clients['recent_activity']))
            <ul class="list-group list-group-flush">

                @foreach($clients['recent_activity'] as $activity)
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <div>
                            <strong>{{ $activity['type'] }}</strong><br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($activity['date'])->format('M d, Y h:i A') }}
                            </small>
                        </div>

                        <span class="badge bg-success">Booked</span>

                    </li>
                @endforeach

            </ul>
        @else
            <p class="text-muted">No recent activity</p>
        @endif
    </div>
</div>

    {{-- Tabs for Bookings --}}
    <ul class="nav nav-tabs mb-3" id="bookingTabs" role="tablist">
        @php
            $bookingTypes = ['flight_bookings'=>'Flights','hotel_bookings'=>'Hotels','car_bookings'=>'Cars','tour_bookings'=>'Tours','visa_requests'=>'Visas'];
        @endphp
        @foreach($bookingTypes as $key => $label)
            @if(isset($clients[$key]) && count($clients[$key]) > 0)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($loop->first) active @endif" id="{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab" aria-controls="{{ $key }}" aria-selected="true">
                        {{ $label }} ({{ count($clients[$key]) }})
                    </button>
                </li>
            @endif
        @endforeach
    </ul>

    <div class="tab-content" id="bookingTabsContent">
        @foreach($bookingTypes as $key => $label)
            @if(isset($clients[$key]) && count($clients[$key]) > 0)
                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}-tab">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $label }} Bookings</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            @foreach(array_keys((array) $clients[$key][0]) as $col)
                                                <th>{{ ucwords(str_replace('_',' ',$col)) }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients[$key] as $booking)
                                            <tr>
                                                @foreach((array) $booking as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script>
    var triggerTabList = [].slice.call(document.querySelectorAll('#bookingTabs button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
</script>

@endsection