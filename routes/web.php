<?php

use App\Livewire\ContentSubmission;
use App\Livewire\ModerationQueue;
use App\Livewire\DashboardStats;
use Illuminate\Support\Facades\Route;

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // User content submission
    Route::get('/submit', ContentSubmission::class)->name('content.submit');
    // Admin routes
    Route::middleware(['can:viewModeration'])->prefix('admin')->group(function () {
        Route::get('/', DashboardStats::class)->name('admin.dashboard');
        Route::get('/moderation-queue', ModerationQueue::class)->name('admin.moderation-queue');
    });
});

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
