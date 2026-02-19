<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            $table->string('seat_label')->nullable()->after('description')
                ->comment('E.g. "General Admission", "VIP Row A", "Block B" — used as seat_number on tickets of this type');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            $table->dropColumn('seat_label');
        });
    }
};
