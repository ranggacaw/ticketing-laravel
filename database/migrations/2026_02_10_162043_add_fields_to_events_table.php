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
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->unsignedBigInteger('venue_id')->nullable()->after('location');
            $table->unsignedBigInteger('organizer_id')->nullable()->after('venue_id');
            $table->string('status')->default('draft')->after('organizer_id'); // draft, published, cancelled, completed

            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('set null');
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
