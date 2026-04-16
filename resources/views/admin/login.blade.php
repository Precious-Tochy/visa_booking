@extends('layouts.admin_layout')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div style="max-width:400px;margin:50px auto;padding:20px;border:1px solid #ddd;border-radius:10px;">
    <h2>Admin Login</h2>
    @if(session('error'))
      <p style="color:red">{{ session('error') }}</p>
    @endif
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
@endsection