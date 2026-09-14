<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', function () { return view('katalog'); });
Route::get('/direktori', function () { return view('direktori'); });
Route::get('/informasi', function () { return view('informasi'); });
Route::get('/konsultasi', function () { return view('konsultasi'); });

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "Dashboard (Coming Soon)";
    })->name('dashboard');
});
