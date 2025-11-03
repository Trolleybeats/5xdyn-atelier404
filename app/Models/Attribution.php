<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribution extends Model
{
    /** @use HasFactory<\Database\Factories\AttributionFactory> */
    use HasFactory;

    protected $fillable = [
        'intervention_id',
        'user_id',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
