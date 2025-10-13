<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /** @use HasFactory<\Database\Factories\NoteFactory> */
    use HasFactory;
    protected $fillable = [
        'contenu',
        'intervention_id',
        'user_id',
    ];

    public function images(){
        return $this->hasMany(Image::class);
    }
    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
