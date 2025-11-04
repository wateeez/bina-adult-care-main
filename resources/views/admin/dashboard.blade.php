@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ Auth::user()->name }}</p>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Services</h3>
            <p>{{ \App\Models\Service::count() }}</p>
        </div>
        <div class="stat-card">
            <h3>Contacts</h3>
            <p>{{ \App\Models\Contact::count() }}</p>
        </div>
    </div>

    <div class="dashboard-actions">
        <a href="{{ route('admin.services') }}" class="btn btn-primary">Manage Services</a>
        <a href="{{ route('admin.contacts') }}" class="btn btn-primary">View Contacts</a>
        <a href="{{ route('admin.content') }}" class="btn btn-primary">Edit Content</a>
    </div>
</div>
@endsection