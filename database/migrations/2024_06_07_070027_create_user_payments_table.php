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
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_subscription_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('plan_id')->nullable();
            $table->unsignedInteger('payment_method_id')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->string('transaction_id', 255)->nullable();
            $table->string('stripe_customer_id', 255)->nullable();
            $table->string('stripe_subscription_id', 255)->nullable();
            $table->string('status', 50)->nullable();
            $table->text('response')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payments');
    }
};
