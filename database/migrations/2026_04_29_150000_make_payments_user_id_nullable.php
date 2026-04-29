<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('payments', 'user_id')) {
            return;
        }

        // Allow guest checkout: user_id can be NULL when user is not logged in.
        DB::statement('ALTER TABLE payments MODIFY user_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        if (!Schema::hasColumn('payments', 'user_id')) {
            return;
        }

        DB::statement('ALTER TABLE payments MODIFY user_id BIGINT UNSIGNED NOT NULL');
    }
};

