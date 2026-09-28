<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', function () { return view('user.katalog'); })->name('katalog.index');
Route::get('/produk/{id}', function ($id) {
    $product = \App\Models\User\Product::with('umkmProfile')->findOrFail($id);
    return view('user.produk_detail', compact('product'));
})->name('produk.detail');
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
    // Admin Routes
    Route::middleware('can:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/admin/umkm/{id}', [AdminController::class, 'showUmkm'])->name('admin.umkm.show');
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
});
