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
        Schema::create('tenant_enquiry_header', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('landlord_id')->nullable();
            $table->smallInteger('status')->comment('1=>Application Requested, 
                                                    2=>Application confirmed, 
                                                    3=>waiting for doc confirm, 
                                                    4=>waiting for doc upload, 
                                                    5=>document uploaded, 
                                                    6=>Document approved, 
                                                    7=>Document return, 
                                                    8=>Document cancel, 
                                                    9=>waiting')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('tenant_enquiry_header');
    }
};
