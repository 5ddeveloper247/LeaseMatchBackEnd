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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('module_code');
            $table->unsignedInteger('from_user_id')->nullable();
            $table->unsignedInteger('to_user_id')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->smallInteger('read_flag')->comment('0=>unread,1=>read')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
