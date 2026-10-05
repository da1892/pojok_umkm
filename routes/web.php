<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\PublicController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', [PublicController::class, 'katalog'])->name('katalog');
Route::get('/katalog/{id}', [PublicController::class, 'showProduct'])->name('katalog.show');

Route::get('/direktori', [PublicController::class, 'direktori'])->name('direktori');
Route::get('/direktori/{id}', [PublicController::class, 'showUmkm'])->name('direktori.show');
Route::get('/informasi', function () { return view('informasi'); });
Route::get('/konsultasi', [PublicController::class, 'konsultasi'])->name('konsultasi');
Route::post('/konsultasi', [PublicController::class, 'storeKonsultasi'])->name('konsultasi.store');
Route::get('/konsultasi/cek', [PublicController::class, 'cekKonsultasi'])->name('konsultasi.cek');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::middleware('can:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Kelola Produk
        Route::get('/admin/produk', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/admin/produk/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.product.edit');
        Route::put('/admin/produk/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
        Route::delete('/admin/produk/{id}', [AdminController::class, 'destroyProduct'])->name('admin.product.destroy');
        
        // Kelola Konsultasi
        Route::get('/admin/konsultasi', [AdminController::class, 'consultations'])->name('admin.consultations');
        Route::post('/admin/konsultasi/{id}/reply', [AdminController::class, 'replyConsultation'])->name('admin.consultations.reply');
        
        // Verifikasi Data
        Route::get('/admin/verifikasi', [AdminController::class, 'verifications'])->name('admin.verifications');
        
        // Laporan
        Route::get('/admin/laporan', [AdminController::class, 'reports'])->name('admin.reports');
        
        // Pengaturan
        Route::get('/admin/pengaturan', [AdminController::class, 'settings'])->name('admin.settings');
        // Data UMKM / Toko
        Route::get('/admin/toko', [AdminController::class, 'stores'])->name('admin.stores');
        
        Route::get('/admin/umkm/{id}', [AdminController::class, 'showUmkm'])->name('admin.umkm.show');
        Route::get('/admin/umkm/{id}/edit', [AdminController::class, 'editUmkm'])->name('admin.umkm.edit');
        Route::put('/admin/umkm/{id}', [AdminController::class, 'updateUmkm'])->name('admin.umkm.update');
        Route::delete('/admin/umkm/{id}', [AdminController::class, 'destroyUmkm'])->name('admin.umkm.destroy');
        Route::post('/admin/umkm/{id}/verify', [AdminController::class, 'verifyUmkm'])->name('admin.umkm.verify');
        Route::post('/admin/umkm/{id}/reject', [AdminController::class, 'rejectUmkm'])->name('admin.umkm.reject');
        
        Route::post('/admin/product/{id}/verify', [AdminController::class, 'verifyProduct'])->name('admin.product.verify');
        Route::post('/admin/product/{id}/reject', [AdminController::class, 'rejectProduct'])->name('admin.product.reject');
    });

    // Store Routes (UMKM)
    Route::get('/toko', [StoreController::class, 'index'])->name('toko.index');
    Route::get('/toko/buka', [StoreController::class, 'create'])->name('toko.create');
    Route::post('/toko/buka', [StoreController::class, 'store'])->name('toko.store');
    
    Route::get('/toko/produk/tambah', [StoreController::class, 'createProduct'])->name('toko.product.create');
    Route::post('/toko/produk/tambah', [StoreController::class, 'storeProduct'])->name('toko.product.store');
    Route::get('/toko/produk/{id}/edit', [StoreController::class, 'editProduct'])->name('toko.product.edit');
    Route::put('/toko/produk/{id}', [StoreController::class, 'updateProduct'])->name('toko.product.update');
    Route::delete('/toko/produk/{id}', [StoreController::class, 'destroyProduct'])->name('toko.product.destroy');
    
    // User Consultations History
    Route::get('/toko/konsultasi', [StoreController::class, 'consultations'])->name('toko.consultations');
});
