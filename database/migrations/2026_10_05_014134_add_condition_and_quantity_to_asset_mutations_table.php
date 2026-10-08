<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_mutations', function (Blueprint $table) {
            $table->foreignId('condition_id')
                ->nullable()
                ->after('lokasi_tujuan_id')
                ->constrained('conditions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('jumlah')
                ->nullable()
                ->after('condition_id');
        });
    }

    public function down(): void
    {
        Schema::table('asset_mutations', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropColumn([
                'condition_id',
                'jumlah',
            ]);
        });
    }
};