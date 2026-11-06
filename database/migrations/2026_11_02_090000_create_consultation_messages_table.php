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
        if (!Schema::hasTable('consultation_messages')) {
            Schema::create('consultation_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
                $table->string('sender_type', 20)->default('user'); // 'user' or 'admin'
                $table->string('sender_name')->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->text('message');
                $table->text('attachment')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('consultation_messages', function (Blueprint $table) {
                if (!Schema::hasColumn('consultation_messages', 'sender_name')) {
                    $table->string('sender_name')->nullable()->after('sender_type');
                }
                if (!Schema::hasColumn('consultation_messages', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->after('sender_name')->constrained('users')->nullOnDelete();
                }
            });
            try {
                DB::statement('ALTER TABLE consultation_messages ALTER COLUMN attachment TYPE text');
            } catch (\Throwable $e) {}
        }

            // Migrasikan riwayat pesan konsultasi yang sudah ada di database
            $consultations = DB::table('consultations')->orderBy('id')->get();
            foreach ($consultations as $c) {
                // Pesan awal dari pemohon
                if (!empty($c->message)) {
                    DB::table('consultation_messages')->insert([
                        'consultation_id' => $c->id,
                        'sender_type' => 'user',
                        'sender_name' => $c->name ?: 'Pengguna',
                        'user_id' => $c->user_id,
                        'message' => $c->message,
                        'attachment' => $c->attachment,
                        'created_at' => $c->created_at ?: now(),
                        'updated_at' => $c->created_at ?: now(),
                    ]);
                }

                // Tanggapan awal dari admin jika sudah pernah dijawab
                if (!empty($c->response)) {
                    DB::table('consultation_messages')->insert([
                        'consultation_id' => $c->id,
                        'sender_type' => 'admin',
                        'sender_name' => 'Admin Dinas Perdagangan & KUKM',
                        'user_id' => $c->admin_id,
                        'message' => $c->response,
                        'attachment' => null,
                        'created_at' => $c->updated_at ?: now(),
                        'updated_at' => $c->updated_at ?: now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_messages');
    }
};
