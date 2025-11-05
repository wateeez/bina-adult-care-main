@extends('admin.layout')

@section('title', 'Edit Benefit')
@section('page-title', 'Edit Benefit')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Benefit</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.benefits.update', $benefit) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $benefit->title) }}" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="icon">Choose Icon *</label>
                <input type="hidden" name="icon" id="icon" value="{{ old('icon', $benefit->icon) }}" required>
                
                <div style="margin-bottom: 10px;">
                    <strong>Selected Icon:</strong> 
                    <i id="selected-icon" class="{{ $benefit->icon }}" style="font-size: 32px; color: var(--primary-color); margin-left: 10px;"></i>
                    <span id="selected-icon-name" style="margin-left: 10px; color: #666;">{{ $benefit->icon }}</span>
                </div>

                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background: #f9f9f9; max-height: 400px; overflow-y: auto;">
                    <div id="icon-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;">
                        <!-- Icons will be populated here -->
                    </div>
                </div>
                
                @error('icon')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $benefit->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="order">Order</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $benefit->order) }}" min="0">
                <small style="color: #666;">Display order (lower numbers appear first)</small>
                @error('order')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Benefit
                </button>
                <a href="{{ route('admin.benefits') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Popular Font Awesome icons for benefits
    const icons = [
        'fas fa-star', 'fas fa-heart', 'fas fa-certificate', 'fas fa-award',
        'fas fa-dollar-sign', 'fas fa-piggy-bank', 'fas fa-coins', 'fas fa-money-bill-wave',
        'fas fa-clock', 'fas fa-calendar', 'fas fa-calendar-check', 'fas fa-business-time',
        'fas fa-user-md', 'fas fa-stethoscope', 'fas fa-hospital', 'fas fa-medkit',
        'fas fa-graduation-cap', 'fas fa-book', 'fas fa-user-graduate', 'fas fa-chalkboard-teacher',
        'fas fa-handshake', 'fas fa-users', 'fas fa-user-friends', 'fas fa-people-carry',
        'fas fa-shield-alt', 'fas fa-lock', 'fas fa-umbrella', 'fas fa-life-ring',
        'fas fa-home', 'fas fa-building', 'fas fa-briefcase', 'fas fa-suitcase',
        'fas fa-chart-line', 'fas fa-rocket', 'fas fa-lightbulb', 'fas fa-bolt',
        'fas fa-gift', 'fas fa-trophy', 'fas fa-medal', 'fas fa-smile',
        'fas fa-thumbs-up', 'fas fa-hand-holding-heart', 'fas fa-hands-helping', 'fas fa-hand-holding-usd',
        'fas fa-check-circle', 'fas fa-check-square', 'fas fa-flag', 'fas fa-bookmark'
    ];

    const iconGrid = document.getElementById('icon-grid');
    const iconInput = document.getElementById('icon');
    const selectedIcon = document.getElementById('selected-icon');
    const selectedIconName = document.getElementById('selected-icon-name');

    // Populate icon grid
    icons.forEach(iconClass => {
        const iconButton = document.createElement('div');
        iconButton.style.cssText = 'padding: 15px; text-align: center; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s; background: white;';
        iconButton.innerHTML = `<i class="${iconClass}" style="font-size: 28px; color: var(--primary-color);"></i>`;
        iconButton.title = iconClass;
        
        iconButton.addEventListener('click', function() {
            // Remove active class from all icons
            document.querySelectorAll('#icon-grid > div').forEach(btn => {
                btn.style.border = '2px solid #ddd';
                btn.style.background = 'white';
            });
            
            // Add active class to selected icon
            this.style.border = '2px solid var(--primary-color)';
            this.style.background = '#e3f2fd';
            
            // Update hidden input and preview
            iconInput.value = iconClass;
            selectedIcon.className = iconClass;
            selectedIconName.textContent = iconClass;
        });

        iconButton.addEventListener('mouseenter', function() {
            if (iconInput.value !== iconClass) {
                this.style.background = '#f5f5f5';
            }
        });

        iconButton.addEventListener('mouseleave', function() {
            if (iconInput.value !== iconClass) {
                this.style.background = 'white';
            }
        });

        iconGrid.appendChild(iconButton);
    });

    // Set initial selected icon
    const initialIcon = iconInput.value;
    document.querySelectorAll('#icon-grid > div').forEach((btn, index) => {
        if (icons[index] === initialIcon) {
            btn.style.border = '2px solid var(--primary-color)';
            btn.style.background = '#e3f2fd';
        }
    });
</script>
@endsection
