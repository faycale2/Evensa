<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InstanceUser extends Pivot
{
    public $incrementing = false; // Clé primaire composite
    public $timestamps = false;   // Pas de timestamps
}