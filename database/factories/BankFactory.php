<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Bank',
            'code' => strtoupper($this->faker->unique()->lexify('???')),
            'logo_url' => $this->faker->imageUrl(),
            'account_name' => $this->faker->company,
            'account_number' => $this->faker->bankAccountNumber,
            'is_active' => true,
        ];
    }
}
