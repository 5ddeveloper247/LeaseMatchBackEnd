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
        Schema::table('user_personal_info', function (Blueprint $table) {
            $table->string('card_number', 16)->nullable()->after('phone_number');
            $table->string('expiration_date', 5)->nullable()->after('card_number'); // Format: MM/YY
            $table->string('cvc', 3)->nullable()->after('expiration_date');
            $table->string('zip_code', 10)->nullable()->after('cvc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_personal_info', function (Blueprint $table) {
            $table->dropColumn(['card_number', 'expiration_date', 'cvc', 'zip_code']);
        });
    }
};
