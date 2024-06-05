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
        Schema::create('landlord_rental', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('landlord_id')->nullable();
            $table->unsignedInteger('size_square_feet')->nullable();
            $table->unsignedInteger('number_of_bedrooms')->nullable();
            $table->unsignedInteger('number_of_bathrooms')->nullable();
            $table->string('rental_type', 100)->nullable();
            $table->decimal('monthly_rent', 8, 2)->nullable();
            $table->decimal('security_deposit', 8, 2)->nullable();
            $table->unsignedInteger('lease_duration')->nullable();
            $table->string('renwal_option', 100)->nullable();
            $table->string('list_of_amenities', 255)->nullable();
            $table->string('special_feature', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlord_rental');
    }
};
