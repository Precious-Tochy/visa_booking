@extends('layouts.admin_layout')

@section('content')

<h3 class="fw-bold">Edit Package</h3>

<form action="{{ route('admin.packages.update', $package->id) }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $package->title }}" class="form-control mb-2">

    <input type="text" name="country" value="{{ $package->country }}" class="form-control mb-2">

    <input type="text" name="duration" value="{{ $package->duration }}" class="form-control mb-2">

    <input type="number" name="price" value="{{ $package->price }}" class="form-control mb-2">

    <div id="features-wrapper">
    @php
        $includes = json_decode($package->includes, true);
    @endphp

    @if($includes)
        @foreach($includes as $key => $item)
            <input type="text" name="includes[]" 
                   class="form-control mb-2" 
                   value="{{ $item }}" 
                   placeholder="Feature {{ $key + 1 }}">
        @endforeach
    @endif
</div>

<button type="button" class="btn btn-sm btn-primary" onclick="addFeature()">
    + Add Feature
</button>
<script>
let count = document.querySelectorAll('#features-wrapper input').length;

function addFeature() {
    count++;

    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'includes[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Feature ' + count;

    document.getElementById('features-wrapper').appendChild(input);
}
function addFeature() {
    count++;

    let div = document.createElement('div');
    div.className = "d-flex mb-2";

    div.innerHTML = `
        <input type="text" name="includes[]" class="form-control me-2" placeholder="Feature ${count}">
        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">X</button>
    `;

    document.getElementById('features-wrapper').appendChild(div);
}
</script>

    <input type="file" name="image" class="form-control mb-2">

    <div class="form-check mb-2">
        <input type="checkbox" name="is_popular" class="form-check-input"
            {{ $package->is_popular ? 'checked' : '' }}>
        <label class="form-check-label">Mark as popular</label>
    </div>

    <button class="btn btn-success">Update Package</button>

</form>

@endsection