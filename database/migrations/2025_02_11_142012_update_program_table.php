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
        Schema::table('programs', function (Blueprint $table) {
            $table->decimal('net_amount', 10, 2)->nullable();
            $table->json('installments')->nullable();
            $table->string('discount_code')->nullable();
            $table->timestamp('discount_expiration')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->integer('redemption_limit')->nullable();
            $table->string('registration_type')->default('basic');
            $table->json('required_fields')->nullable();
            $table->json('custom_questions')->nullable();
            $table->boolean('donations_enabled')->default(false);
            $table->json('donation_presets')->nullable();
            $table->boolean('allow_custom_donation')->default(false);
            $table->decimal('min_donation', 10, 2)->nullable();
            $table->decimal('max_donation', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn([
                'net_amount',
                'installments',
                'discount_code',
                'discount_expiration',
                'discount_amount',
                'redemption_limit',
                'registration_type',
                'required_fields',
                'custom_questions',
                'donations_enabled',
                'donation_presets',
                'allow_custom_donation',
                'min_donation',
                'max_donation',
            ]);
        });
    }
};
