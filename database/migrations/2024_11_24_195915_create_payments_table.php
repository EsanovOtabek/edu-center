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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, places: 2);
            $table->decimal('remain_balance', 15, 2);
            $table->string('currency', 3)->default('UZS');
            $table->enum('payment_method', ['cash', 'bank', 'online'])->default('cash');
            $table->string('receipt')->nullable();
            $table->date('payment_period_start'); // To'lov boshlanish sanasi
            $table->date('payment_period_end');   // To'lov tugash sanasi
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
