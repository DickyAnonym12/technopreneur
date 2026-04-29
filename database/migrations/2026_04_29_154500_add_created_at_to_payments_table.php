<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('payments', 'created_at')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            // We rely on DB default for new rows; existing rows are backfilled below.
            $table->timestamp('created_at')->nullable()->after('verification_status');
        });

        // Backfill existing rows so ordering works for historical data.
        DB::table('payments')->whereNull('created_at')->update(['created_at' => DB::raw('CURRENT_TIMESTAMP')]);

        // Ensure new rows automatically get a timestamp even though the model doesn't use timestamps.
        DB::statement('ALTER TABLE payments MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down(): void
    {
        if (!Schema::hasColumn('payments', 'created_at')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
};

