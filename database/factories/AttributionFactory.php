<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribution>
 */
class AttributionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::get()->random()->id,
            'intervention_id' => \App\Models\Intervention::get()->random()->id,
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
