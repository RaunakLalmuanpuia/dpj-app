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
            $table->string('plan_type');

            // Razorpay specific IDs
            $table->string('razorpay_order_id')->unique();
            $table->string('razorpay_payment_id')->nullable()->unique();
            $table->string('razorpay_signature')->nullable();

            // Financial details
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('INR');

            // Status tracking
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');

            // Drive tracking (Optional: to know which folder this payment created)
            $table->string('folder_id_created')->nullable();
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
