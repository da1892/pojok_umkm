<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_informations', function (Blueprint $table) {
            $table->text('images')->nullable()->after('image_path'); // JSON array of multiple image paths
        });
    }

    public function down(): void
    {
        Schema::table('news_informations', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
