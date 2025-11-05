@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="welcome-section">
    <h2>Welcome, {{ $admin->email }}</h2>
    <p>
        Role: 
        @if($admin->isSuperAdmin())
            <span class="badge badge-danger"><i class="fas fa-crown"></i> Super Admin</span>
        @else
            <span class="badge badge-success"><i class="fas fa-edit"></i> Content Editor</span>
        @endif
    </p>
    <p style="color: #666; font-size: 0.9rem;">
        Last Activity: {{ $admin->last_activity ? $admin->last_activity->diffForHumans() : 'First login' }}
    </p>
</div>

<!-- Super Admin Stats -->
@if($admin->isSuperAdmin())
<div class="stats-grid">
    <div class="stat-card blue">
        <h3>Total Services</h3>
        <div class="stat-value">{{ \App\Models\Service::count() }}</div>
    </div>
    <div class="stat-card green">
        <h3>Contact Messages</h3>
        <div class="stat-value">{{ \App\Models\Contact::count() }}</div>
    </div>
    <div class="stat-card orange">
        <h3>New Messages</h3>
        <div class="stat-value">{{ \App\Models\Contact::whereDate('created_at', today())->count() }}</div>
    </div>
    <div class="stat-card red">
        <h3>Total Admins</h3>
        <div class="stat-value">{{ \App\Models\UserAdmin::count() }}</div>
    </div>
</div>
@else
<!-- Content Editor Stats -->
<div class="stats-grid">
    <div class="stat-card blue">
        <h3>Total Services</h3>
        <div class="stat-value">{{ \App\Models\Service::count() }}</div>
    </div>
    <div class="stat-card green">
        <h3>Contact Messages</h3>
        <div class="stat-value">{{ \App\Models\Contact::count() }}</div>
    </div>
    <div class="stat-card orange">
        <h3>New Messages</h3>
        <div class="stat-value">{{ \App\Models\Contact::whereDate('created_at', today())->count() }}</div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>Recent Contact Messages</h2>
        <a href="{{ route('admin.contacts') }}" class="btn btn-primary btn-sm">View All</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse(\App\Models\Contact::latest()->take(5)->get() as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No contact messages yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h2>Services</h2>
        <a href="{{ route('admin.services.create') }}" class="btn btn-success btn-sm">Add New Service</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse(\App\Models\Service::latest()->take(5)->get() as $service)
                <tr>
                    <td>{{ $service->title }}</td>
                    <td>{{ Str::limit($service->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No services yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
.welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.welcome-section h2 {
    margin: 0 0 0.5rem 0;
    font-size: 1.8rem;
}

.welcome-section p {
    margin: 0.5rem 0;
}

.badge {
    padding: 0.35rem 0.65rem;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 600;
}

.badge-danger {
    background: #dc3545;
    color: white;
}

.badge-success {
    background: #28a745;
    color: white;
}

.stat-card.red {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
</style>
@endsection