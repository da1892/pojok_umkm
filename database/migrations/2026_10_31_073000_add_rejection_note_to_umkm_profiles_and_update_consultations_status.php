<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom rejection_note pada umkm_profiles
        Schema::table('umkm_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('umkm_profiles', 'rejection_note')) {
                $table->text('rejection_note')->nullable();
            }
        });

        // 2. Perbarui check constraint status pada tabel consultations agar mendukung status 'diterima' dan 'ditolak'
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE consultations DROP CONSTRAINT IF EXISTS consultations_status_check');
            DB::statement("ALTER TABLE consultations ADD CONSTRAINT consultations_status_check CHECK (status IN ('menunggu', 'diterima', 'diproses', 'selesai', 'ditolak'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('umkm_profiles', 'rejection_note')) {
                $table->dropColumn('rejection_note');
            }
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE consultations DROP CONSTRAINT IF EXISTS consultations_status_check');
            DB::statement("ALTER TABLE consultations ADD CONSTRAINT consultations_status_check CHECK (status IN ('menunggu', 'diproses', 'selesai'))");
        }
    }
};
