<?php

namespace Database\Seeders;

use App\Models\TypeAppareil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\JsonSchema\Types\Type;

class TypeAppareilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // TypeAppareil::factory()->count(10)->create();
        TypeAppareil::factory()->create(['nom' => 'Ordinateur']);
        TypeAppareil::factory()->create(['nom' => 'Smartphone']);
        TypeAppareil::factory()->create(['nom' => 'Tablette']);
        TypeAppareil::factory()->create(['nom' => 'Imprimante']);
        TypeAppareil::factory()->create(['nom' => 'Routeur']);
        TypeAppareil::factory()->create(['nom' => 'Console']);
        TypeAppareil::factory()->create(['nom' => 'Disque dur']);
        TypeAppareil::factory()->create(['nom' => 'Écran']);
        TypeAppareil::factory()->create(['nom' => 'Appareil photo']);
        TypeAppareil::factory()->create(['nom' => 'Autre']);


    }
}
