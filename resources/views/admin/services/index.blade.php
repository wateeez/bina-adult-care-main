@extends('admin.layout')

@section('title', 'Services')
@section('page-title', 'Manage Services')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Services</h2>
        <a href="{{ route('admin.services.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Service
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->title }}</td>
                    <td>{{ Str::limit($service->description, 100) }}</td>
                    <td>
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        @else
                            <span style="color: #999;">No image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this service?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px;">
                        <p style="color: #999;">No services found. Create your first service!</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
