<?php

namespace App\Console\Commands;

use App\Services\WilayahService;
use Illuminate\Console\Command;

class SyncWilayahCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wilayah:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data master Kecamatan dan Desa Kabupaten Wonogiri dari file master_kecamatan.xlsx dan master_desa.xlsx ke sistem.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=== SINKRONISASI MASTER WILAYAH WONOGIRI DARI EXCEL ===");
        $this->line("Memulai pembacaan file master_kecamatan.xlsx dan master_desa.xlsx...");

        try {
            $start = microtime(true);
            $res = WilayahService::syncFromExcel();
            $duration = round(microtime(true) - $start, 2);

            $this->newLine();
            $this->info("✅ Berhasil membaca dan mengekstrak data asli Wonogiri!");
            $this->table(
                ['Parameter', 'Keterangan'],
                [
                    ['File Master Kecamatan', $res['kecamatan_file']],
                    ['File Master Desa', $res['desa_file']],
                    ['File Output Cache', $res['target_json']],
                    ['Total Kecamatan Wonogiri', $res['kecamatan_count'] . ' Kecamatan'],
                    ['Total Desa/Kelurahan', $res['desa_count'] . ' Desa/Kelurahan'],
                    ['Waktu Pemrosesan', "{$duration} detik"],
                ]
            );

            $this->info("Semua dropdown di website (Dashboard, Form UMKM, Profil UMKM) sekarang telah 100% sinkron dengan data resmi file Excel Wonogiri.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("❌ Gagal menyinkronkan data: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
