<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Backfill barcode_data with uuid to ensure uniqueness
        DB::table('tickets')->update(['barcode_data' => DB::raw('uuid')]);

        // 2. Add unique index
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('barcode_data', 255)->change(); // Ensure it's not text for indexing (though modern MySQL handles prefix)
            $table->unique('barcode_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropUnique(['barcode_data']);
            $table->text('barcode_data')->change();
        });
    }
};
