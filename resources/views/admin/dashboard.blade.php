@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
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
@endsection