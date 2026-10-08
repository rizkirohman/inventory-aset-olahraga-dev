<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_mutations', function (Blueprint $table) {
            $table->id();

            // Aset yang dimutasi
            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Lokasi sebelum dan sesudah mutasi
            $table->foreignId('lokasi_asal_id')
                ->constrained('locations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('lokasi_tujuan_id')
                ->constrained('locations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Informasi mutasi
            $table->date('tanggal_mutasi');
            $table->string('alasan')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_mutations');
    }
};