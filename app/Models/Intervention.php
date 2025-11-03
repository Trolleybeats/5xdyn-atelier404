<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    /** @use HasFactory<\Database\Factories\InterventionFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
        'statut',
        'date_prevue',
        'priorite',
        'type_appareil_id',
        'client_id',
    ];

    public function typeAppareil()
    {
        return $this->belongsTo(TypeAppareil::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function attributions(){
        return $this->hasMany(Attribution::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }

    public function derniere_attribution(){
        return $this->hasOne(Attribution::class)->latestOfMany();
        // return $this->attributions()->latest()->first();
    }
}
