<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            $table->string('seat_prefix', 20)->nullable()->after('seat_label')
                ->comment('If set, seats are auto-numbered: prefix + sequential number. E.g. "A" => A1, A2, A3...');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            $table->dropColumn('seat_prefix');
        });
    }
};
