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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_plan_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('withdraw_id')->nullable()->constrained()->cascadeOnDelete();
            $table->double('amount');
            $table->enum('status', ['pending', 'approved', 'failed'])->default('approved');
            $table->boolean('payment_status')->default(true);
            $table->boolean('sum')->default(false);
            $table->longText('reference')->nullable();
            $table->enum('type', [
                'deposit',
                'withdraw',
                'daily profit',
                'withdraw fees',
                'transfer',
                'commission',
                'kyc bonus',
                'reward',
                'plan activation',
                'balance adjustment',
            ])->default('deposit');
            $table->string('additional_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
