<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('amount', 8, 4)->after('id');
            $table->foreignId('transaction_type_id')->constrained('transaction_types')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['transaction_type_id']);
            $table->dropColumn('transaction_type_id');
            $table->dropColumn('amount');
        });

        Schema::dropIfExists('transaction_types');
    }
};
