<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_informations', function (Blueprint $table) {
            $table->text('excerpt')->nullable()->after('title');
            $table->boolean('is_published')->default(true)->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('news_informations', function (Blueprint $table) {
            $table->dropColumn(['excerpt', 'is_published']);
        });
    }
};
