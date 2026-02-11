<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $events = Event::all();
        foreach ($events as $event) {
            if (empty($event->slug)) {
                $event->save(); // This triggers the booted method which populates the slug
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse as slugs are just data.
    }
};
