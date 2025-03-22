<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('yield_percentage_modifiers', function (Blueprint $table) {
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->foreignId('yield_index_id')->constrained('yield_index')->cascadeOnDelete();
            $table->decimal('value', 8, 4)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yield_percentage_modifiers');
    }
};
