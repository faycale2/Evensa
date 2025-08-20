<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 
        'description',
        'statut',
        'instance_id',
        'created_by'
    ];

    // Relation avec l'utilisateur créateur
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation avec les pièces jointes
    public function attachments() {
        return $this->hasMany(Attachment::class);
    }
    
    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Conversion automatique des dates
    protected $casts = [
        'dates' => 'datetime',
    ];
}