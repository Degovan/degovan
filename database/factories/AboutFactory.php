<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\About>
 */
class AboutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'banner' => Str::random().'.png',
            'vision' => fake()->name(),
            'mission' => fake()->paragraph(),
            'attachment' => Str::random().'.pdf',
        ];
    }
}
