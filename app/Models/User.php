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

    protected $fillable = [
        'name',
        'email',
        'password',
        'role' // 'prof', 'etudiant', 'directeur'
    ];

    /**
     * Champs cachés dans les réponses JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversion des types de champs
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 2. RELATIONS AVEC LES AUTRES MODÈLES
    // -----------------------------------
    /**
     * Relation Many-to-Many avec les instances (départements/clubs)
     */
public function instances()
{
    return $this->belongsToMany(Instance::class) // Pas besoin de préciser la table si vous suivez les conventions
                ->using(InstanceUser::class)     // Spécifie le modèle pivot
                ->withPivot([]);                 // Prêt pour colonnes supplémentai            // Si vous ajoutez des timestamps plus tard
}

    /**
     * Relation One-to-Many avec les demandes d'événements (créateur)
     */
    public function eventRequests()
    {
        return $this->hasMany(EventRequest::class, 'created_by');
    }

    /**
     * Relation One-to-Many avec les commentaires
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 3. MÉTHODES PERSONNALISÉES (OPTIONNEL)
    // --------------------------------------
    /**
     * Vérifie si l'utilisateur est un administrateur
     */
    public function isAdmin()
    {
        return $this->role === 'Super Administrateur';
    }
}