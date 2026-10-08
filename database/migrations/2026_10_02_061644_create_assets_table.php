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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            // Identitas aset
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');

            // Relasi master data
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('condition_id')
                ->constrained('conditions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Informasi barang
            $table->string('merek')->nullable();
            $table->string('tipe')->nullable();
            $table->string('nomor_seri')->nullable();

            // Perolehan
            $table->year('tahun_perolehan')->nullable();
            $table->decimal('harga_perolehan', 15, 2)->nullable();
            $table->string('sumber_dana')->nullable();

            // Jumlah
            $table->unsignedInteger('jumlah')->default(1);
            $table->string('satuan')->default('Unit');

            // Foto dan keterangan
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
