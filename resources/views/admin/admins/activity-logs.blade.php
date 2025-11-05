@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-history"></i> Admin Activity Logs</h1>
    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Admins
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Recent Activity</h3>
        <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem;">
            Showing {{ $logs->total() }} total activity records
        </p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Description</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td style="white-space: nowrap;">
                            {{ $log->created_at->format('M d, Y') }}<br>
                            <small style="color: #666;">{{ $log->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            @if($log->admin)
                                {{ $log->admin->email }}
                            @else
                                <span class="text-muted">Deleted Admin</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $actionIcons = [
                                    'login' => ['icon' => 'fa-sign-in-alt', 'color' => '#28a745'],
                                    'logout' => ['icon' => 'fa-sign-out-alt', 'color' => '#6c757d'],
                                    'login_failed' => ['icon' => 'fa-exclamation-triangle', 'color' => '#dc3545'],
                                    'create' => ['icon' => 'fa-plus-circle', 'color' => '#17a2b8'],
                                    'update' => ['icon' => 'fa-edit', 'color' => '#ffc107'],
                                    'delete' => ['icon' => 'fa-trash', 'color' => '#dc3545'],
                                    'password_change' => ['icon' => 'fa-key', 'color' => '#fd7e14'],
                                ];
                                $action = $actionIcons[$log->action_type] ?? ['icon' => 'fa-info-circle', 'color' => '#6c757d'];
                            @endphp
                            <span style="color: {{ $action['color'] }};">
                                <i class="fas {{ $action['icon'] }}"></i> {{ ucfirst(str_replace('_', ' ', $log->action_type)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ ucfirst($log->module) }}</span>
                        </td>
                        <td>
                            {{ $log->description }}
                            @if($log->old_values || $log->new_values)
                                <button 
                                    onclick="showDetails({{ json_encode($log->old_values) }}, {{ json_encode($log->new_values) }})" 
                                    class="btn btn-sm btn-link"
                                    style="padding: 0; margin-left: 0.5rem;">
                                    <i class="fas fa-info-circle"></i> View Details
                                </button>
                            @endif
                        </td>
                        <td style="font-family: monospace;">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No activity logs found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-info-circle"></i> Change Details</h2>
            <button onclick="closeDetailsModal()" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
            <div id="oldValues" style="margin-bottom: 1rem;"></div>
            <div id="newValues"></div>
        </div>
        <div class="modal-footer">
            <button onclick="closeDetailsModal()" class="btn btn-secondary">Close</button>
        </div>
    </div>
</div>

<style>
.table-responsive {
    overflow-x: auto;
}

.badge {
    padding: 0.35rem 0.65rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-secondary {
    background: #6c757d;
    color: white;
}

.text-muted {
    color: #6c757d;
}

.pagination-wrapper {
    margin-top: 1rem;
    display: flex;
    justify-content: center;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: #999;
}

.close-btn:hover {
    color: #333;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
</style>

<script>
function showDetails(oldValues, newValues) {
    const oldDiv = document.getElementById('oldValues');
    const newDiv = document.getElementById('newValues');
    
    if (oldValues) {
        oldDiv.innerHTML = '<h4>Old Values:</h4><pre>' + JSON.stringify(oldValues, null, 2) + '</pre>';
    } else {
        oldDiv.innerHTML = '';
    }
    
    if (newValues) {
        newDiv.innerHTML = '<h4>New Values:</h4><pre>' + JSON.stringify(newValues, null, 2) + '</pre>';
    } else {
        newDiv.innerHTML = '';
    }
    
    document.getElementById('detailsModal').style.display = 'flex';
}

function closeDetailsModal() {
    document.getElementById('detailsModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('detailsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailsModal();
    }
});
</script>
@endsection
