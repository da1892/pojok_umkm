<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\PublicController;

Route::get('/', [PublicController::class, 'welcome'])->name('home');

Route::get('/katalog', [PublicController::class, 'katalog'])->name('katalog');
Route::get('/katalog/{id}', [PublicController::class, 'showProduct'])->name('katalog.show');

Route::get('/direktori', [PublicController::class, 'direktori'])->name('direktori');
Route::get('/direktori/{id}', [PublicController::class, 'showUmkm'])->name('direktori.show');
Route::get('/api/peta-umkm', [PublicController::class, 'getMapUmkmData'])->name('api.peta.umkm');
Route::get('/informasi', [PublicController::class, 'informasi'])->name('informasi');
Route::get('/informasi/{id}', [PublicController::class, 'showNews'])->name('informasi.show');

// Info & Panduan Publik
Route::get('/panduan', [PublicController::class, 'panduan'])->name('panduan');
Route::get('/info-panduan', function() { return redirect()->route('panduan'); });

// Konsultasi Publik
Route::get('/konsultasi', [PublicController::class, 'konsultasi'])->name('konsultasi');
Route::post('/konsultasi', [PublicController::class, 'storeKonsultasi'])->name('konsultasi.store');
Route::get('/konsultasi/cek/{ticket_id?}', [PublicController::class, 'cekKonsultasi'])->name('konsultasi.cek');
Route::post('/konsultasi/cek/{ticket_id}/balas', [PublicController::class, 'replyKonsultasiUser'])->name('konsultasi.cek.balas');

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
        Route::get('/admin/produk/tambah', [AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::post('/admin/produk/tambah', [AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::get('/admin/produk/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.product.edit');
        Route::put('/admin/produk/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
        Route::patch('/admin/produk/{id}/toggle-featured', [AdminController::class, 'toggleFeaturedProduct'])->name('admin.product.toggle-featured');
        Route::delete('/admin/produk/{id}', [AdminController::class, 'destroyProduct'])->name('admin.product.destroy');
        
        // Kelola Konsultasi
        Route::get('/admin/konsultasi', [AdminController::class, 'consultations'])->name('admin.consultations');
        Route::post('/admin/konsultasi/{id}/reply', [AdminController::class, 'replyConsultation'])->name('admin.consultations.reply');
        
        // Verifikasi Data
        Route::get('/admin/verifikasi', [AdminController::class, 'verifications'])->name('admin.verifications');
        
        // Laporan & Statistik Pengunjung
        Route::get('/admin/pengunjung', [AdminController::class, 'visitorStats'])->name('admin.visitors');
        Route::get('/admin/laporan', [AdminController::class, 'visitorStats'])->name('admin.reports');
        
        // Kelola Berita & Kegiatan
        Route::get('/admin/berita', [AdminController::class, 'news'])->name('admin.news');
        Route::get('/admin/berita/tambah', [AdminController::class, 'createNews'])->name('admin.news.create');
        Route::post('/admin/berita', [AdminController::class, 'storeNews'])->name('admin.news.store');
        Route::get('/admin/berita/{id}/edit', [AdminController::class, 'editNews'])->name('admin.news.edit');
        Route::put('/admin/berita/{id}', [AdminController::class, 'updateNews'])->name('admin.news.update');
        Route::patch('/admin/berita/{id}/toggle', [AdminController::class, 'toggleNews'])->name('admin.news.toggle');
        Route::delete('/admin/berita/{id}', [AdminController::class, 'destroyNews'])->name('admin.news.destroy');

        // Pengaturan
        Route::get('/admin/pengaturan', [AdminController::class, 'settings'])->name('admin.settings');
        // Data UMKM
        Route::get('/admin/toko', [AdminController::class, 'stores'])->name('admin.stores');
        
        // Manajemen Pengguna & UMKM (Fitur Management User Dinas Perdagangan)
        Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
        Route::get('/admin/users/tambah', [AdminController::class, 'createUmkmUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUmkmUser'])->name('admin.users.store');
        Route::get('/admin/users/{umkm_id}/produk/tambah', [AdminController::class, 'createProductForUmkm'])->name('admin.users.product.create');
        Route::post('/admin/users/{umkm_id}/produk', [AdminController::class, 'storeProductForUmkm'])->name('admin.users.product.store');
        Route::post('/admin/users/{user_id}/reset-password', [AdminController::class, 'resetPasswordUser'])->name('admin.users.reset_password');
        Route::delete('/admin/users/{user_id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::get('/admin/users/unduh-template', [AdminController::class, 'downloadExcelTemplate'])->name('admin.users.template');
        Route::post('/admin/users/import-excel', [AdminController::class, 'importExcel'])->name('admin.users.import');
        Route::post('/admin/users/tambah-admin', [AdminController::class, 'storeAdminUser'])->name('admin.users.admin.store');

        // Redirect kompatibilitas lama
        Route::get('/admin/binaan', function() {
            return redirect()->route('admin.users.index');
        })->name('admin.binaan.index');
        Route::get('/admin/binaan/tambah-umkm', function() {
            return redirect()->route('admin.users.create');
        })->name('admin.binaan.umkm.create');
        Route::post('/admin/binaan/tambah-umkm', [AdminController::class, 'binaanStoreUmkm'])->name('admin.binaan.umkm.store');
        Route::get('/admin/binaan/tambah-produk', [AdminController::class, 'binaanCreateProduct'])->name('admin.binaan.product.create');
        Route::post('/admin/binaan/tambah-produk', [AdminController::class, 'binaanStoreProduct'])->name('admin.binaan.product.store');
        Route::post('/admin/binaan/{id}/klaim', [AdminController::class, 'binaanClaimUmkm'])->name('admin.binaan.claim');
        
        Route::get('/admin/umkm/{id}', [AdminController::class, 'showUmkm'])->name('admin.umkm.show');
        Route::get('/admin/umkm/{id}/edit', [AdminController::class, 'editUmkm'])->name('admin.umkm.edit');
        Route::put('/admin/umkm/{id}', [AdminController::class, 'updateUmkm'])->name('admin.umkm.update');
        Route::delete('/admin/umkm/{id}', [AdminController::class, 'destroyUmkm'])->name('admin.umkm.destroy');
        Route::post('/admin/umkm/{id}/verify', [AdminController::class, 'verifyUmkm'])->name('admin.umkm.verify');
        Route::post('/admin/umkm/{id}/reject', [AdminController::class, 'rejectUmkm'])->name('admin.umkm.reject');
        
        Route::post('/admin/product/{id}/verify', [AdminController::class, 'verifyProduct'])->name('admin.product.verify');
        Route::post('/admin/product/{id}/reject', [AdminController::class, 'rejectProduct'])->name('admin.product.reject');
    });

    // UMKM Routes
    Route::get('/toko', [StoreController::class, 'index'])->name('toko.index');
    Route::get('/toko/profil', [StoreController::class, 'profile'])->name('toko.profile');
    Route::put('/toko/profil', [StoreController::class, 'updateProfile'])->name('toko.profile.update');
    Route::post('/toko/ajukan-ulang', [StoreController::class, 'resubmitVerification'])->name('toko.resubmit');
    Route::get('/toko/buka', [StoreController::class, 'create'])->name('toko.create');
    Route::post('/toko/buka', [StoreController::class, 'store'])->name('toko.store');
    
    Route::get('/toko/produk/tambah', [StoreController::class, 'createProduct'])->name('toko.product.create');
    Route::post('/toko/produk/tambah', [StoreController::class, 'storeProduct'])->name('toko.product.store');
    Route::get('/toko/produk/{id}/edit', [StoreController::class, 'editProduct'])->name('toko.product.edit');
    Route::put('/toko/produk/{id}', [StoreController::class, 'updateProduct'])->name('toko.product.update');
    Route::delete('/toko/produk/{id}', [StoreController::class, 'destroyProduct'])->name('toko.product.destroy');
    Route::delete('/toko/hapus', [StoreController::class, 'destroyStore'])->name('toko.destroy');
    Route::delete('/toko/hapus-akun', [StoreController::class, 'destroyAccount'])->name('toko.destroyAccount');
    
    // User Consultations History
    Route::get('/toko/konsultasi', [StoreController::class, 'consultations'])->name('toko.consultations');
});
