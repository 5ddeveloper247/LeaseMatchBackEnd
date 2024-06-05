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
        Schema::create('landlord_property', function (Blueprint $table) {
            $table->id(); // Automatically creates an auto-incrementing primary key
            $table->unsignedInteger('landlord_id')->nullable();
            $table->string('street_address', 255)->nullable();
            $table->string('appartment_number', 100)->nullable();
            $table->string('neighbourhood', 100)->nullable();
            $table->string('property_type', 100)->nullable();
            $table->unsignedInteger('number_of_units')->nullable();
            $table->unsignedInteger('year_built')->nullable();
            $table->unsignedInteger('major_renovation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlord_property');
    }
};
