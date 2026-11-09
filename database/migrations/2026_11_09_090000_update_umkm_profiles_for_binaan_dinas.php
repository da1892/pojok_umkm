<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('umkm_profiles', 'is_managed_by_admin')) {
                $table->boolean('is_managed_by_admin')->default(false)->after('status');
            }
        });

        // Pastikan kolom user_id boleh NULL (nullable) di Postgres / MySQL
        try {
            DB::statement('ALTER TABLE umkm_profiles ALTER COLUMN user_id DROP NOT NULL');
        } catch (\Throwable $e) {
            // Abaikan jika sudah nullable atau DB driver berbeda
        }
    }

    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('umkm_profiles', 'is_managed_by_admin')) {
                $table->dropColumn('is_managed_by_admin');
            }
        });
    }
};
