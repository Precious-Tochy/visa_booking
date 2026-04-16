@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<h3 class="fw-bold">Tour Packages</h3>

<a href="{{ route('admin.packages.create') }}" class="btn btn-primary mb-3">
    + Add New Package
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Country</th>
            <th>Price</th>
            <th>Popular</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($packages as $package)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $package->image) }}" width="70">
            </td>
            <td>{{ $package->title }}</td>
            <td>{{ $package->country }}</td>
            <td>${{ $package->price }}</td>
            <td>
                {{ $package->is_popular ? 'Yes' : 'No' }}
            </td>

            <!-- ACTION BUTTONS -->
            <td>
                <a href="{{ route('admin.packages.edit', $package->id) }}" 
                   class="btn btn-sm btn-warning">
                   Edit
                </a>

                <form action="{{ route('admin.packages.delete', $package->id) }}" 
                      method="POST" 
                      style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this package?')">
                        Delete
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection