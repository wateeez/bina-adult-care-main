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

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login'])->name('admin.login');
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
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
    });
});

// API routes for admin (non-API routes should be in api.php)
Route::prefix('api/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
});
