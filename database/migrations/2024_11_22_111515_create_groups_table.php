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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Guruh nomi
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Fanni tanlash
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade'); // O'qituvchini tanlash
            $table->enum('status', ['active', 'finished'])->default('active');
            $table->decimal('price', 8, 2); // Guruh narxi
            $table->softDeletes(); // "deleted_at" ustunini qo'shish
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
