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
        Schema::create('enquiry_header', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('landlord_id')->nullable();
            $table->smallInteger('status')->comment('1=>Application Request, 
                                                    2=>Application request confirm, 
                                                    3=>Upload Docs, 
                                                    4=>Doc Attached, 
                                                    5=>Approved, 
                                                    6=>Document Rejected')->nullable();
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
        Schema::dropIfExists('enquiry_header');
    }
};
