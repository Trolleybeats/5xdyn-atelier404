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
        TypeAppareil::factory()->count(10)->create();
    }
}
