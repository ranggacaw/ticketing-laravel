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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->string('section')->nullable();
            $table->string('row')->nullable();
            $table->string('number');
            $table->string('status')->default('available'); // available, booked, blocked
            $table->string('type')->default('standard'); // standard, vip, accessible
            $table->timestamps();

            $table->unique(['venue_id', 'section', 'row', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
