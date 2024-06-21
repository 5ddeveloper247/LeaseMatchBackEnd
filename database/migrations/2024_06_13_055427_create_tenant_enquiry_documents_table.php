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
        Schema::create('tenant_enquiry_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('enquiry_id')->nullable();
            $table->unsignedInteger('enquiry_request_id')->nullable();
            $table->unsignedInteger('document_id')->nullable();
            $table->string('doc_name')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_enquiry_documents');
    }
};
