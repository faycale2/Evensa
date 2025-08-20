<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'token', 'role', 'instance_id', 'expires_at', 'used_at','used',
    ];

    protected $dates = ['expires_at', 'used_at'];

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

        public function isExpired()
    {
        return $this->expires_at < now();
    }

    public function isUsed()
    {
        return $this->used;
    }

    public function isValid()
    {
        return !$this->isExpired() && !$this->isUsed();
    }

}
