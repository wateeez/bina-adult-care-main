<?php if($activePopup): ?>
<div id="announcementPopup" class="announcement-popup-overlay" style="display: none;">
    <div class="announcement-popup-modal">
        <button type="button" class="btn-close announcement-popup-close" onclick="closeAnnouncementPopup()" aria-label="Close"></button>
        
        <div class="announcement-popup-content">
            <?php if($activePopup->image_path): ?>
                <div class="announcement-popup-image">
                    <img src="<?php echo e($activePopup->image_url); ?>" alt="<?php echo e($activePopup->title); ?>">
                </div>
            <?php endif; ?>
            
            <?php if($activePopup->text_content): ?>
                <div class="announcement-popup-text">
                    <p><?php echo e($activePopup->text_content); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if($activePopup->link_url): ?>
                <div class="announcement-popup-action">
                    <a href="<?php echo e($activePopup->link_url); ?>" class="btn btn-primary announcement-popup-btn">
                        <?php echo e($activePopup->link_text ?? 'Learn More'); ?>

                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.announcement-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease-out;
}

.announcement-popup-modal {
    background: white;
    border-radius: 15px;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.4s ease-out;
}

.announcement-popup-close {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 1;
    background: white;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.announcement-popup-content {
    padding: 20px;
}

.announcement-popup-image {
    margin-bottom: 20px;
}

.announcement-popup-image img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.announcement-popup-text {
    margin-bottom: 20px;
    font-size: 1.1rem;
    line-height: 1.6;
    color: #333;
}

.announcement-popup-action {
    text-align: center;
}

.announcement-popup-btn {
    background: #4A90E2;
    border-color: #4A90E2;
    padding: 12px 30px;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.announcement-popup-btn:hover {
    background: #357ABD;
    border-color: #357ABD;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

@media (max-width: 768px) {
    .announcement-popup-modal {
        width: 95%;
        max-width: none;
    }
    
    .announcement-popup-text {
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('announcementPopup');
    const delay = <?php echo e($activePopup->delay_seconds ?? 3); ?> * 1000;
    const showOnce = <?php echo e($activePopup->show_once_per_session ? 'true' : 'false'); ?>;
    const popupId = 'announcement_popup_<?php echo e($activePopup->id); ?>';
    
    // Check if already shown in this session
    if (showOnce && sessionStorage.getItem(popupId)) {
        return;
    }
    
    // Show popup after delay
    setTimeout(() => {
        popup.style.display = 'flex';
        
        // Mark as shown if show_once is enabled
        if (showOnce) {
            sessionStorage.setItem(popupId, 'shown');
        }
    }, delay);
});

function closeAnnouncementPopup() {
    const popup = document.getElementById('announcementPopup');
    popup.style.animation = 'fadeOut 0.3s ease-out';
    setTimeout(() => {
        popup.style.display = 'none';
    }, 300);
}

// Close on overlay click
document.getElementById('announcementPopup')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAnnouncementPopup();
    }
});

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAnnouncementPopup();
    }
});
</script>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\bina-adult-care-main-master\resources\views/partials/announcement-popup.blade.php ENDPATH**/ ?>