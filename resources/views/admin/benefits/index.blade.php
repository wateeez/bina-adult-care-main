@extends('admin.layout')

@section('title', 'Benefits Management')
@section('page-title', 'Benefits Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Manage Benefits</h2>
        <a href="{{ route('admin.benefits.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Benefit
        </a>
    </div>
    
    @if($benefits->isEmpty())
        <div style="padding: 40px; text-align: center;">
            <p style="color: #999;">No benefits found. Click "Add New Benefit" to create one.</p>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Icon</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($benefits as $benefit)
                <tr>
                    <td>{{ $benefit->order }}</td>
                    <td>
                        <i class="{{ $benefit->icon }}" style="font-size: 24px; color: var(--primary-color);"></i>
                    </td>
                    <td>{{ $benefit->title }}</td>
                    <td>{{ Str::limit($benefit->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.benefits.edit', $benefit) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.benefits.destroy', $benefit) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this benefit?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
