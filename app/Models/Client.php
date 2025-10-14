<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'téléphone',
    ];

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

}
