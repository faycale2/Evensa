<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\EventRequest;

class AnnouncementController extends Controller
{
    /**
     * Liste des annonces officielles
     */
    public function index()
    {
        return view('public.events.index', [
            'events' => EventRequest::latest()->get()
        ]);
    }
}