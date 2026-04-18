<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'action_id')) {
                $table->uuid('action_id')->nullable()->after('order_id');
                $table->unique('action_id');
            }
        });

        // Backfill existing rows so each payment can be targeted individually.
        // UUID() is a MySQL function returning a 36-char UUID string.
        DB::table('payments')
            ->whereNull('action_id')
            ->update(['action_id' => DB::raw('UUID()')]);
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'action_id')) {
                $table->dropUnique(['action_id']);
                $table->dropColumn('action_id');
            }
        });
    }
};

