<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropForeign(['condition_id']);

            $table->dropColumn([
                'location_id',
                'condition_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->foreignId('location_id')
                ->nullable()
                ->constrained('locations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('condition_id')
                ->nullable()
                ->constrained('conditions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }
};