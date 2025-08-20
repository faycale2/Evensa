<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instance extends Model
{
    /**
     * Désactive les timestamps
     * @var bool
     */
    public $timestamps = false;

    /**
     * Champs modifiables en masse
     * @var array
     */
    protected $fillable = [
        'nom', 
        'type' // 'departement', 'club', 'laboratoire'
    ];

    /**
     * Relation Many-to-Many avec les User via la table pivot
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
public function creator()
{
    return $this->belongsToMany(User::class) // Pas besoin de préciser la table si vous suivez les conventions
                ->using(InstanceUser::class)     // Spécifie le modèle pivot
                ->withPivot([])  ;               // Prêt pour colonnes supplémentaires
                            // Si vous ajoutez des timestamps plus tard
}


    /**
     * Relation One-to-Many avec les EventRequest
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventRequests()
    {
        return $this->hasMany(EventRequest::class);
    }

   
    
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}