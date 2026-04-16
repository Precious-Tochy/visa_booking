@extends('layouts.admin_layout')

@section('content')
@include('sweetalert::alert')

<h3 class="fw-bold">Add Tour Package</h3>

<form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="title" class="form-control mb-2" placeholder="Package Title" required>

    <input type="text" name="country" class="form-control mb-2" placeholder="Country" required>

    <input type="text" name="duration" class="form-control mb-2" placeholder="Duration" required>

    <input type="number" name="price" class="form-control mb-2" placeholder="Price" required>

    
     <div id="features-wrapper">
    <input type="text" name="includes[]" class="form-control mb-2" placeholder="Feature 1">
</div>

<button type="button" class="btn btn-sm btn-primary" onclick="addFeature()">
    + Add Feature
</button>
<script>
let count = 1;

function addFeature() {
    count++;

    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'includes[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Feature ' + count;

    document.getElementById('features-wrapper').appendChild(input);
}
</script>
    <input type="file" name="image" class="form-control mb-2" required>

    <div class="form-check mb-2">
        <input type="checkbox" name="is_popular" class="form-check-input">
        <label>Mark as Popular</label>
    </div>

    <button class="btn btn-success">Save Package</button>
</form>

@endsection