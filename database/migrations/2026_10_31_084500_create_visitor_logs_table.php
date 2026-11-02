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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable();
            $table->string('session_id', 100)->nullable()->index();
            $table->text('url');
            $table->string('route_name', 100)->nullable();
            $table->string('page_name', 255)->nullable();
            $table->string('device', 50)->default('Desktop');
            $table->string('platform', 50)->default('Windows');
            $table->string('browser', 50)->default('Chrome');
            $table->text('user_agent')->nullable();
            $table->text('referer')->nullable();
            $table->timestamp('visited_at')->useCurrent()->index();
            $table->timestamps();

            $table->index(['visited_at', 'device']);
            $table->index(['visited_at', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
