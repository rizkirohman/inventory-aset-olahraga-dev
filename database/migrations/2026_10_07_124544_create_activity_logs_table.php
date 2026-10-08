<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // User yang melakukan aktivitas
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Jenis aktivitas: created, updated, deleted, finalized, dll.
            $table->string('action', 50);

            // Model/data yang terkena aktivitas
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();

            // Deskripsi aktivitas yang mudah dibaca
            $table->text('description');

            // Data sebelum perubahan
            $table->json('old_values')->nullable();

            // Data sesudah perubahan
            $table->json('new_values')->nullable();

            // Informasi akses
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Index untuk mempercepat pencarian/filter
            $table->index(['subject_type', 'subject_id']);
            $table->index('action');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};