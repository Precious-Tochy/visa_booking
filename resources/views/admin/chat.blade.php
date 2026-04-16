@extends('layouts.admin_layout')

@section('page-title', 'Chat Messages')

@section('content')

<div class="table-container">
    <h3>Customer Chat Messages</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Session</th>
                <th>Message</th>
                <th>Sender</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $msg)
            <tr>
                <td>{{ $msg->id }}</td>
                <td>{{ $msg->session_id }}</td>
                <td>{{ $msg->message }}</td>
                <td>
                    @if($msg->sender == 'user')
                        <span style="color:blue;">User</span>
                    @else
                        <span style="color:green;">Bot</span>
                    @endif
                </td>
                <td>{{ $msg->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection