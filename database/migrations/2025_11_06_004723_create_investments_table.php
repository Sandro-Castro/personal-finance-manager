<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['stocks', 'funds', 'treasury', 'fixed_income', 'crypto', 'others']);
            $table->decimal('initial_amount', 12, 2);
            $table->decimal('current_value', 12, 2);
            $table->date('investment_date');
            $table->decimal('expected_return', 5, 2)->nullable();
            $table->enum('status', ['active', 'redeemed', 'cancelled'])->default('active');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};