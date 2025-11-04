<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Chemin vers le dossier des images
        $notesPath = storage_path('app/public/notes');
        
        // Vérifier si le dossier existe
        if (!is_dir($notesPath)) {
            // Si le dossier n'existe pas, créer un path par défaut
            $extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = fake()->randomElement($extensions);
            $filename = fake()->uuid() . '.' . $extension;
            return [
                'path' => 'notes/' . $filename,
                'note_id' => \App\Models\Note::get()->random()->id,
                'created_at' => now(),
            ];
        }
        
        // Scanner le dossier pour les images existantes
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $images = [];
        
        foreach (scandir($notesPath) as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($extension, $imageExtensions)) {
                $images[] = $file;
            }
        }
        
        // Si aucune image n'existe, créer un path par défaut
        if (empty($images)) {
            $extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = fake()->randomElement($extensions);
            $filename = fake()->uuid() . '.' . $extension;
            $path = 'notes/' . $filename;
        } else {
            // Sélectionner une image au hasard parmi celles existantes
            $selectedImage = fake()->randomElement($images);
            $path = 'notes/' . $selectedImage;
        }
        
        return [
            'path' => $path,
            'note_id' => \App\Models\Note::get()->random()->id,
            'created_at' => now(),
        ];
    }
}
