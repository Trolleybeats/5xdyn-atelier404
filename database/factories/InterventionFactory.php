<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervention>
 */
class InterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'description' => fake()->paragraph(),
            'statut' => fake()->randomElement(['Nouvelle_demande','Diagnostic','En_réparations','Terminé','Non_réparable']),
            'date_prevue' => fake()->dateTimeBetween('now', '+1 month'),
            'priorite' => fake()->randomElement(['faible','moyenne','elevee','critique']),
            'type_appareil_id' => \App\Models\TypeAppareil::get()->random()->id,
            'client_id' => \App\Models\Client::get()->random()->id,
        ];
    }
}
