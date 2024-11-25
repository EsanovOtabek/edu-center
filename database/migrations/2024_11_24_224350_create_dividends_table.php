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
        Schema::create('dividends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade'); // Teacher ID
            $table->enum('type', ['salary', 'advance']); // Oylik yoki Avans
            $table->decimal('amount', 10, 2); // Summasi
            $table->date('date'); // Sana
            $table->timestamps(); // Yaratilish va yangilanish sanalari
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dividends');
    }
};
