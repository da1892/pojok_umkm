<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Hapus cache publik saat data UMKM, Produk, atau Berita diperbarui
     */
    public static function clearPublicCache(): void
    {
        try {
            Cache::forget('public_homepage_all_data');
            Cache::forget('umkm_map_list_verified');
            Cache::forget('admin_dashboard_stats');
            Cache::forget('admin_products_districts');
            Cache::forget('admin_products_categories');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal menghapus cache: ' . $e->getMessage());
        }
    }

    /**
     * Hapus semua cache aplikasi
     */
    public static function clearAll(): void
    {
        try {
            Cache::flush();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal flush cache: ' . $e->getMessage());
        }
    }
}
