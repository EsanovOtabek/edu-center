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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // 'users' jadvaliga bog'langan
            $table->string('fio'); // To'liq ismi
            $table->string('phone'); // Telefon raqami
            $table->string('passport_number'); // Pasport nomeri
            $table->string('image'); // O'qituvchi rasmi
            $table->decimal('salary_percentage', 5, 2)->default(0); // Oylik foizlarda
            $table->decimal('balance', 10, 2)->default(0); // Balansdagi pul
            $table->softDeletes(); // "deleted_at" ustunini qo'shish
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
