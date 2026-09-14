<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ticket_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->text('response')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
