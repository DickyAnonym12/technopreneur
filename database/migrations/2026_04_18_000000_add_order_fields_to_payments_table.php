<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('user_id');
            $table->text('product_name')->nullable()->after('customer_name');
            $table->string('payment_proof')->nullable()->after('product_name');
            $table->string('verification_status')->default('pending')->after('payment_proof');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'product_name', 'payment_proof', 'verification_status']);
        });
    }
};
