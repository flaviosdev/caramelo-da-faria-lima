<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_yield_history', function (Blueprint $table) {
            $table->id();  // Coluna 'id' como chave primária
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');  // Chave estrangeira para 'assets'
            $table->foreignId('yield_percentage_id')->constrained('yield_percentage')->onDelete('cascade');  // Chave estrangeira para 'yield_percentage'
            $table->date('yield_date');  // Data do rendimento
            $table->timestamps();  // 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_yield_history');
    }
};
