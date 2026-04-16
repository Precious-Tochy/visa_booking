@extends('layouts.admin_layout')
@section('page-title', 'Edit Client')
@section('content')
@include('sweetalert::alert')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Client: {{ $clients['summary']['name'] ?? $clients['summary']['phone'] }}</h3>
        <a href="{{ route('admin.clients') }}" class="btn btn-outline-secondary">Back to Clients</a>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.clients.update', $clients['summary']['phone']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $clients['summary']['name'] ?? '') }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $clients['summary']['email'] ?? '') }}" required>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $clients['summary']['phone']) }}" required>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Client</button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection