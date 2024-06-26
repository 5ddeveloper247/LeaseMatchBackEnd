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
        Schema::create('landlord_personal', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255);
            $table->string('email', 255)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->smallInteger('status')->comment('0=>InActive, 1=>Active')->nullable();
            $table->smallInteger('enquiry_status')->comment('1=>Available, 2=>Blocked, 3=>Booked')->default('1')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlord_personal');
    }
};
