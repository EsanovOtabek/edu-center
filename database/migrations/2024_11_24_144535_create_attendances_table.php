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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date'); // Davomat sanasi
            $table->enum('status', ['present', 'absent', 'late'])->default('absent'); // Davomat holati
            $table->boolean('marked_by_teacher')->default(true);// O'qituvchi davomat qilganmi
            $table->unique(['group_id', 'student_id', 'attendance_date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
