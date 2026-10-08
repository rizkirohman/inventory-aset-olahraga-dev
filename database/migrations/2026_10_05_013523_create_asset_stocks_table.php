<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('condition_id')
                ->constrained('conditions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('jumlah');

            $table->timestamps();

            $table->unique(
                ['asset_id', 'location_id', 'condition_id'],
                'asset_stocks_asset_location_condition_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_stocks');
    }
};