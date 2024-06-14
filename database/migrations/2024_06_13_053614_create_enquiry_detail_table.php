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
        Schema::create('enquiry_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('enquiry_id')->nullable();
            $table->smallInteger('type')->comment('1=>Application Request, 2=>Doc Upload')->nullable();
            $table->text('message')->nullable();
            $table->smallInteger('status')->comment('1=>Application Request, 
                                                    2=>Application request confirm, 
                                                    3=>Upload Docs, 
                                                    4=>Doc Attached, 
                                                    5=>Approved, 
                                                    6=>Document Rejected')->nullable();
            $table->date('date')->nullable();
            $table->string('submitted_by', 100)->comment('1=>Customer, 2=>Admin')->nullable();
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
        Schema::dropIfExists('enquiry_detail');
    }
};
