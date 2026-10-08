<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_id')
                ->constrained('inventories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('condition_id')
                ->constrained('conditions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('jumlah_tercatat');

            $table->unsignedInteger('jumlah_ditemukan');

            $table->integer('selisih');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(
                ['inventory_id', 'asset_id', 'condition_id'],
                'inventory_details_inventory_asset_condition_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_details');
    }
};