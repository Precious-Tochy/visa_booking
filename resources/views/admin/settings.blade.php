@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')
<h2 class=" mb-4">Admin Settings</h2>
<div class="container mt-5 ">
    <div class="card shadow-sm ">
        <div class="card-body">
            

            <!-- Profile Picture -->
            <div class="text-center mb-4">
                @if($admin->profile_picture)
                    <img src="{{ asset('uploads/admins/'.$admin->profile_picture) }}" class="rounded-circle" width="120" height="120" alt="Profile Picture">
                @else
                    <img src="{{ asset('visa-booking/image/profile.jpg') }}" class="rounded-circle" width="120" height="120" alt="Profile Picture">
                @endif
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Support Email</label>
                    <input type="email" name="support_email" class="form-control" value="{{ old('support_email', $admin->support_email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $admin->site_name ?? 'Visa Booking') }}" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Save Settings</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert Success -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}",
        timer: 2500,
        showConfirmButton: false
    });
</script>
@endif
@endsection