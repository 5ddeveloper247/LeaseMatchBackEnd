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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('industry_sector')->nullable();
            $table->string('year')->nullable();
            $table->string('company_website')->nullable();
            $table->string('full_name')->nullable();
            $table->string('job_title');
            $table->string('phone_number', 18)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('type_of_space')->nullable();
            $table->string('preferred_lease_term')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
