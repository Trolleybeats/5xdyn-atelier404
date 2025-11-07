<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function attributions()
    {
        return $this->hasMany(Attribution::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function nbInterventions()
    {
        return $this->hasManyThrough(Intervention::class, Attribution::class, 'user_id', 'id', 'id', 'intervention_id')->distinct('intervention_id')->count();
    }

    public function nbInterventionsAttribuees()
    {
        // Count interventions whose latest attribution belongs to this user
        return Intervention::whereHas('derniereAttribution', function ($q) {
            $q->where('user_id', $this->id);
        })->distinct()->count();
    }

    public function nbInterventionsEnCours()
    {
        return $this->nbInterventionsAttribuees() - $this->nbInterventionsTerminees() - $this->nbInterventionsEchouees();
    }
    public function nbInterventionsTerminees()
    {
        return Intervention::whereHas('derniereAttribution', function ($q) {
            $q->where('user_id', $this->id);
        })->where('statut', 'Terminé')
        ->distinct()->count();
    }
    public function nbInterventionsEchouees()
    {
        return Intervention::whereHas('derniereAttribution', function ($q) {
            $q->where('user_id', $this->id);
        })->where('statut', 'Non_réparable')
        ->distinct()->count();
    }


}
