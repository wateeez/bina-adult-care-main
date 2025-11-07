@if($activeBar)
<div id="announcementBar" class="announcement-bar" style="background-color: {{ $activeBar->background_color }}; color: {{ $activeBar->text_color }};">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between py-2 px-3">
            <div class="d-flex align-items-center flex-grow-1">
                @if($activeBar->image_path)
                    <img src="{{ $activeBar->image_url }}" alt="{{ $activeBar->title }}" class="announcement-bar-image me-3">
                @endif
                
                @if($activeBar->text_content)
                    <span class="announcement-bar-text">{{ $activeBar->text_content }}</span>
                @endif
                
                @if($activeBar->link_url)
                    <a href="{{ $activeBar->link_url }}" class="btn btn-sm announcement-bar-btn ms-3" style="color: {{ $activeBar->text_color }}; border-color: {{ $activeBar->text_color }};">
                        {{ $activeBar->link_text ?? 'Learn More' }}
                    </a>
                @endif
            </div>
            
            <button type="button" class="btn-close announcement-bar-close" onclick="closeAnnouncementBar()" aria-label="Close" style="filter: invert(1);"></button>
        </div>
    </div>
</div>

<style>
.announcement-bar {
    position: sticky;
    top: 0;
    z-index: 1030;
    width: 100%;
    animation: slideDown 0.5s ease-out;
}

.announcement-bar-image {
    max-height: 60px;
    max-width: 150px;
    object-fit: contain;
}

.announcement-bar-text {
    font-size: 0.95rem;
    font-weight: 500;
}

.announcement-bar-btn {
    background: transparent;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.announcement-bar-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

.announcement-bar-close {
    opacity: 0.8;
}

.announcement-bar-close:hover {
    opacity: 1;
}

@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .announcement-bar-image {
        max-height: 40px;
        max-width: 100px;
    }
    
    .announcement-bar-text {
        font-size: 0.85rem;
    }
    
    .announcement-bar-btn {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>

<script>
function closeAnnouncementBar() {
    const bar = document.getElementById('announcementBar');
    bar.style.animation = 'slideUp 0.3s ease-out';
    setTimeout(() => {
        bar.style.display = 'none';
    }, 300);
}

// Add slideUp animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endif
