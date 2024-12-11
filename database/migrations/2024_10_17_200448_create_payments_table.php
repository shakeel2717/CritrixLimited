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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->double('amount');
            $table->string('txn_id')->unique();
            $table->string('address');
            $table->string('confirms_needed');
            $table->string('checkout_url');
            $table->string('status_url');
            $table->string('qrcode_url');
            $table->string('timeout');
            $table->enum('status', ['created', 'pending', 'completed', 'failed'])->default('created');
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
