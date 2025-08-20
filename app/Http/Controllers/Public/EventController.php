<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EventRequest;

class EventController extends Controller
{
    /**
     * Liste des événements validés
     */
    public function index()
    {
        return view('public.events.index', [
            'events' => EventRequest::where('status', 'approved')
                      ->with('instance')
                      ->latest()
                      ->get()
        ]);
    }
}