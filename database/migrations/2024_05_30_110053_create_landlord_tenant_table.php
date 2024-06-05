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
        Schema::create('landlord_tenant', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('landlord_id');
            $table->string('tenant_characteristics', 255)->nullable();
            $table->string('credit_score', 100)->nullable();
            $table->string('income_requirements', 100)->nullable();
            $table->string('rental_history', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlord_tenant');
    }
};
