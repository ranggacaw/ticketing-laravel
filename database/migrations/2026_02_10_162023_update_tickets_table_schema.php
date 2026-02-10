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
            $table->unsignedBigInteger('ticket_type_id')->nullable()->after('event_id');
            $table->unsignedBigInteger('seat_id')->nullable()->after('ticket_type_id');
            $table->string('secure_token')->unique()->after('seat_id')->nullable();
            $table->string('status')->default('issued')->after('secure_token'); // issued, used, cancelled, refunded

            $table->foreign('ticket_type_id')->references('id')->on('ticket_types')->onDelete('cascade');
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};
