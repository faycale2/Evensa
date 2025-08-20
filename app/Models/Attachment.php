<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_request_id',
        'file_path'
    ];

    public function eventRequest()
    {
        return $this->belongsTo(EventRequest::class);
    }
}

