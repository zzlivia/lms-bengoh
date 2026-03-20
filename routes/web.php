<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityStoryController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LectureSectionController;
use App\Http\Controllers\AdminSettingsController;

//127.0.0.1:8000 acts as main page
Route::get('/', function () {return view('homepage');});

//authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//admin
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/user', [AdminController::class, 'userManagement'])->name('user.management');

    Route::get('/course', [AdminController::class, 'courseManagement'])->name('course.management');

    Route::get('/progress', [AdminController::class, 'progress'])->name('progress');

    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

    Route::get('/help', [AdminController::class, 'helpSupport'])->name('help');

    Route::get('/password-requests', [AdminController::class, 'passwordRequests'])->name('password.requests');

    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

