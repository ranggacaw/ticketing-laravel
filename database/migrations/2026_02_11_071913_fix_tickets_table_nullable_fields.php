<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('seat_number')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->dropUnique('tickets_seat_number_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('seat_number')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
            // $table->unique('seat_number');
        });
    }
};
