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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Expense category
            $table->decimal('amount', 15, 2); // Expense amount
            $table->string('currency')->default('UZS'); // Currency, default UZS
            $table->enum('payment_method', ['cash', 'cashusd', 'bank', 'transfer']); // Payment method
            $table->text('description')->nullable(); // Optional comment for the expense
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
