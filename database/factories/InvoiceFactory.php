<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project' => fake()->sentence(),
            'status' => fake()->randomElement(['pending', 'success', 'failed']),
            'amount' => random_int(10000, 1000000),
            'description' => fake()->sentence(),
        ];
    }
}
