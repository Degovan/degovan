<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contributor>
 */
class ContributorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'photo' => Str::random().'.png',
            'role' => fake()->randomElement([
                'Backend Developer',
                'Frontend Developer',
                'Fullstack Developer',
            ]),
            'quotes' => Str::random(),
        ];
    }
}
