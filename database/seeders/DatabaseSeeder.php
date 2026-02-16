<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BankSeeder::class);

        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'budiharso@mail.com'],
            [
                'name' => 'Budiharso',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'user', 
            ]
        );

        // \App\Models\Ticket::factory()->count(10)->create();

        // $this->call([
        //     BankSeeder::class,
        // ]);
    }
}
