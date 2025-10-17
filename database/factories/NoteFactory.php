<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contenu' => fake()->realTextBetween($minNbChars = 20, $maxNbChars = 200),
            'intervention_id' => \App\Models\Intervention::get()->random()->id,
            'user_id' => \App\Models\User::get()->random()->id,
            'created_at' => fake()->dateTimeBetween('-1 months', 'now'),
        ];
    }
}
