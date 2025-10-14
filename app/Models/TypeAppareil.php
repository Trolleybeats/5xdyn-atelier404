<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAppareil extends Model
{
    /** @use HasFactory<\Database\Factories\TypeAppareilFactory> */
    use HasFactory;
<<<<<<< Updated upstream
=======
    protected $fillable = [
        'nom',
    ];
    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public static function getAll()
    {
        return self::all();
    }
>>>>>>> Stashed changes
}
