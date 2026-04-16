@extends('layouts.admin_layout')
@section('page-title', 'Create Client')
@section('content')
@include('sweetalert::alert')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Create New Client</h3>
        <a href="{{ route('admin.clients') }}" class="btn btn-outline-secondary">Back to Clients</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.clients.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Client</button>
            </form>

        </div>
    </div>
</div>
@endsection