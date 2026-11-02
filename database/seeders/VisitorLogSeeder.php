<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisitorLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Sistem analitik hanya membaca dan mencatat data pengunjung nyata yang terdeteksi secara otomatis oleh sistem (TrackVisitorMiddleware).
     */
    public function run(): void
    {
        // Tidak menginput data dummy agar statistik 100% murni dan valid dari data nyata yang terdeteksi
    }
}
