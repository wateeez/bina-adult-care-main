<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\File;

// Frontend routes
Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('home');
Route::get('/services', [App\Http\Controllers\FrontendController::class, 'services'])->name('services');
Route::get('/about', [App\Http\Controllers\FrontendController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\FrontendController::class, 'submitContact'])->name('contact.submit');
Route::get('/gallery', [App\Http\Controllers\GalleryPageController::class, 'index'])->name('gallery');

// Blog routes (SEO-friendly URLs)
Route::get('/blog', [App\Http\Controllers\BlogPageController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogPageController::class, 'show'])->name('blog.show');

// Admin routes
Route::prefix('admin')->group(function () {
    // Auth routes (no middleware)
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
    
    // Content Editor routes (both super admin and content editor can access)
    Route::middleware(['content.editor'])->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            $admin = \App\Models\UserAdmin::find(session('admin_id'));
            return view('admin.dashboard', compact('admin'));
        })->name('admin.dashboard');

        // Services Management
        Route::get('/services', [App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('admin.services');
        Route::get('/services/create', [App\Http\Controllers\Admin\ServiceController::class, 'create'])->name('admin.services.create');
        Route::post('/services', [App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('admin.services.store');
        Route::get('/services/{service}/edit', [App\Http\Controllers\Admin\ServiceController::class, 'edit'])->name('admin.services.edit');
        Route::put('/services/{service}', [App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/services/{service}', [App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('admin.services.destroy');

        // Contacts Management
        Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.contacts');
        Route::get('/contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'show'])->name('admin.contacts.show');
        Route::delete('/contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('admin.contacts.destroy');

        // Content Management
        Route::get('/content', [App\Http\Controllers\Admin\ContentController::class, 'index'])->name('admin.content');
        Route::put('/content/{section}', [App\Http\Controllers\Admin\ContentController::class, 'update'])->name('admin.content.update');

        // Benefits Management
        Route::get('/benefits', [App\Http\Controllers\Admin\BenefitController::class, 'index'])->name('admin.benefits');
        Route::get('/benefits/create', [App\Http\Controllers\Admin\BenefitController::class, 'create'])->name('admin.benefits.create');
        Route::post('/benefits', [App\Http\Controllers\Admin\BenefitController::class, 'store'])->name('admin.benefits.store');
        Route::get('/benefits/{benefit}/edit', [App\Http\Controllers\Admin\BenefitController::class, 'edit'])->name('admin.benefits.edit');
        Route::put('/benefits/{benefit}', [App\Http\Controllers\Admin\BenefitController::class, 'update'])->name('admin.benefits.update');
        Route::delete('/benefits/{benefit}', [App\Http\Controllers\Admin\BenefitController::class, 'destroy'])->name('admin.benefits.destroy');
        
        // Gallery Management
        Route::get('/gallery', [App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('admin.gallery.index');
        Route::post('/gallery', [App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::put('/gallery/{gallery}', [App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('admin.gallery.update');
        Route::delete('/gallery/{gallery}', [App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
        Route::post('/gallery/update-order', [App\Http\Controllers\Admin\GalleryController::class, 'updateOrder'])->name('admin.gallery.update-order');
        Route::post('/gallery/toggle-homepage', [App\Http\Controllers\Admin\GalleryController::class, 'toggleHomepage'])->name('admin.gallery.toggle-homepage');
        
        // Blog Management
        Route::get('/blog', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blog.index');
        Route::get('/blog/create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('admin.blog.create');
        Route::post('/blog', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('/blog/{blog}/edit', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::put('/blog/{blog}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin.blog.update');
        Route::delete('/blog/{blog}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin.blog.destroy');
        Route::post('/blog/{blog}/toggle-publish', [App\Http\Controllers\Admin\BlogController::class, 'togglePublish'])->name('admin.blog.toggle-publish');
        Route::delete('/blog/paragraph-image/{image}', [App\Http\Controllers\Admin\BlogController::class, 'deleteParagraphImage'])->name('admin.blog.paragraph-image.delete');
        
        // Announcement Management
        Route::get('/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('admin.announcements.index');
        Route::get('/announcements/create', [App\Http\Controllers\Admin\AnnouncementController::class, 'create'])->name('admin.announcements.create');
        Route::post('/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('admin.announcements.store');
        Route::get('/announcements/{announcement}/edit', [App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])->name('admin.announcements.edit');
        Route::put('/announcements/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('admin.announcements.update');
        Route::delete('/announcements/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');
        Route::post('/announcements/{announcement}/toggle', [App\Http\Controllers\Admin\AnnouncementController::class, 'toggleActive'])->name('admin.announcements.toggle');
        Route::delete('/announcements/{announcement}/delete-image', [App\Http\Controllers\Admin\AnnouncementController::class, 'deleteImage'])->name('admin.announcements.delete-image');
    });

    // Super Admin only routes
    Route::middleware(['super.admin'])->group(function () {
        // Admin Management
        Route::get('/admins', [App\Http\Controllers\Admin\AdminManagementController::class, 'index'])->name('admin.admins.index');
        Route::get('/admins/create', [App\Http\Controllers\Admin\AdminManagementController::class, 'create'])->name('admin.admins.create');
        Route::post('/admins', [App\Http\Controllers\Admin\AdminManagementController::class, 'store'])->name('admin.admins.store');
        Route::get('/admins/{admin}/edit', [App\Http\Controllers\Admin\AdminManagementController::class, 'edit'])->name('admin.admins.edit');
        Route::put('/admins/{admin}', [App\Http\Controllers\Admin\AdminManagementController::class, 'update'])->name('admin.admins.update');
        Route::put('/admins/{admin}/change-password', [App\Http\Controllers\Admin\AdminManagementController::class, 'changePassword'])->name('admin.admins.change-password');
        Route::delete('/admins/{admin}', [App\Http\Controllers\Admin\AdminManagementController::class, 'destroy'])->name('admin.admins.destroy');
        
        // Activity Logs
        Route::get('/activity-logs', [App\Http\Controllers\Admin\AdminManagementController::class, 'activityLogs'])->name('admin.activity-logs');
        
        // Site Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SiteSettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings/logo', [App\Http\Controllers\Admin\SiteSettingsController::class, 'updateLogo'])->name('admin.settings.logo.update');
        Route::delete('/settings/logo', [App\Http\Controllers\Admin\SiteSettingsController::class, 'removeLogo'])->name('admin.settings.logo.remove');
        Route::post('/settings/sitename', [App\Http\Controllers\Admin\SiteSettingsController::class, 'updateSiteName'])->name('admin.settings.sitename.update');
    });
});

// API routes for admin (non-API routes should be in api.php)
Route::prefix('api/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
});
