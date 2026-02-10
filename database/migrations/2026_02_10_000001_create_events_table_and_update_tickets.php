<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->timestamps();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Seed a default event for existing tickets
        $eventId = DB::table('events')->insertGetId([
            'name' => 'Default Event',
            'description' => 'Migrated Event',
            'location' => 'Main Hall',
            'start_time' => now()->addDays(30), // Future event by default for "Upcoming" test
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tickets')->update(['event_id' => $eventId]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::dropIfExists('events');
    }
};
