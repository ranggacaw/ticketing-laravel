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
        // Link existing tickets to users by matching email
        // We iterate to be compatible with both MySQL and SQLite
        $users = DB::table('users')->select('id', 'email')->get();

        foreach ($users as $user) {
            DB::table('tickets')
                ->where('user_email', $user->email)
                ->whereNull('user_id') // Only update if not already set
                ->update(['user_id' => $user->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op for data migration as we can't distinguish which links we created vs existed
    }
};
