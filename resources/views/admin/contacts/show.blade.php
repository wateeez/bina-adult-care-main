@extends('admin.layout')

@section('title', 'View Contact Message')
@section('page-title', 'Contact Message Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Message from {{ $contact->name }}</h2>
        <a href="{{ route('admin.contacts') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Messages
        </a>
    </div>
    
    <div style="padding: 20px;">
        <div class="form-group">
            <label><strong>Name:</strong></label>
            <p>{{ $contact->name }}</p>
        </div>

        <div class="form-group">
            <label><strong>Email:</strong></label>
            <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
        </div>

        <div class="form-group">
            <label><strong>Phone:</strong></label>
            <p><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></p>
        </div>

        <div class="form-group">
            <label><strong>Date Received:</strong></label>
            <p>{{ $contact->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>

        <div class="form-group">
            <label><strong>Message:</strong></label>
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #3498db;">
                <p style="white-space: pre-wrap;">{{ $contact->message }}</p>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <a href="mailto:{{ $contact->email }}" class="btn btn-success">
                <i class="fas fa-reply"></i> Reply via Email
            </a>
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
