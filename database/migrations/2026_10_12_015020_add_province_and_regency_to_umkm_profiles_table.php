<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->string('province')->nullable()->default('Jawa Tengah')->after('address');
            $table->string('regency')->nullable()->default('Kabupaten Wonogiri')->after('province');
            $table->string('postal_code')->nullable()->after('village');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->dropColumn(['province', 'regency', 'postal_code']);
        });
    }
};
