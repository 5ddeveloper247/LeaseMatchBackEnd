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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->double('initial_price', 8, 2)->nullable();
            $table->double('monthly_price', 8, 2)->nullable();
            $table->integer('number_of_matches')->nullable();
            $table->smallInteger('directly_contact_flag')->nullable()->comment('0=>disable, 1=>enable')->default(0);
            $table->smallInteger('process_application_flag')->nullable()->comment('0=>disable, 1=>enable')->default(0);
            $table->smallInteger('necessary_doc_flag')->nullable()->comment('0=>disable, 1=>enable')->default(0);
            $table->smallInteger('free_trial')->nullable()->comment('0=>disable, 1=>enable')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
