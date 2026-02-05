<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('user_name');
            $table->string('user_email');
            $table->string('seat_number');
            $table->decimal('price', 10, 2);
            $table->string('type');
            $table->text('barcode_data');
            $table->timestamps();

            $table->unique(['seat_number']); // Ensuring one ticket per seat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
