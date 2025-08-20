<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\app\Models\User;
use Carbon\Carbon;
class EventRequestController extends Controller
{
   
    public function publicIndex(Request $request)
    {
        $query = EventRequest::where('statut', 'commission_validated');

        // 🔎 Filtrage par type d’instance
        if ($request->has('instance')) {
            $query->where('instance_id', $request->instance);
        }

        // 🔎 Filtrage par mot-clé
        if ($request->has('q')) {
            $query->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
        }

        $today = Carbon::today();

        $events = [
            'a_venir' => (clone $query)->where('dates', '>', $today)->get(),
            'en_cours' => (clone $query)->whereDate('dates', '=', $today)->get(),
            'passes' => (clone $query)->where('dates', '<', $today)->get(),
        ];

        return view('events.index', compact('events'));
    }


    // Mes demandes
    public function myRequests()
    {
        $requests = EventRequest::where('created_by', Auth::id())->get();
        return response()->json($requests);
    }

    // Vue d’une demande
    public function show($id)
    {
        $request = EventRequest::with(['comments.user', 'attachments'])
                               ->where('id', $id)
                               ->where('created_by', Auth::id())
                               ->firstOrFail();

        return response()->json($request);
    }

    // Créer une demande
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'lieu' => 'required|string|max:255',
            'dates' => 'required|date',
            'instance_id' => 'required|exists:instances,id',
        ]);

        $data['created_by'] = Auth::id();
        $data['statut'] = 'draft';

        $eventRequest = EventRequest::create($data);

        return response()->json($eventRequest, 201);
    }

    // Modifier une demande
    public function update(Request $request, $id)
    {
        $eventRequest = EventRequest::where('id', $id)
                                    ->where('created_by', Auth::id())
                                    ->firstOrFail();

        if ($eventRequest->statut !== 'draft') {
            return response()->json(['error' => 'Impossible de modifier une demande soumise'], 403);
        }

        $eventRequest->update($request->only(['titre', 'description', 'lieu', 'dates']));

        return response()->json($eventRequest);
    }

    // Supprimer une demande
    public function destroy($id)
    {
        $eventRequest = EventRequest::where('id', $id)
                                    ->where('created_by', Auth::id())
                                    ->firstOrFail();

        $eventRequest->delete();

        return response()->json(['message' => 'Demande supprimée']);
    }

    // Soumettre une demande
    public function submit($id)
    {
        $eventRequest = EventRequest::where('id', $id)
                                    ->where('created_by', Auth::id())
                                    ->firstOrFail();

        if ($eventRequest->statut !== 'draft') {
            return response()->json(['error' => 'La demande est déjà soumise'], 403);
        }

        $eventRequest->update(['statut' => 'pending']);

        return response()->json(['message' => 'Demande soumise avec succès']);
    }
    /**
     * Affiche une demande spécifique
     */
}    