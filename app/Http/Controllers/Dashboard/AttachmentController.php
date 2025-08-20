<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\Attachment;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AttachmentController extends Controller
{
    // Upload fichier
    public function store(Request $request, $eventId)
    {
        $event = EventRequest::where('id', $eventId)
                             ->where('created_by', Auth::id())
                             ->firstOrFail();

        $request->validate([
            'file' => 'required|file|max:2048', // 2MB max
        ]);

        $path = $request->file('file')->store('attachments', 'public');

        $attachment = Attachment::create([
            'file_path' => $path,
            'event_request_id' => $event->id,
        ]);

        return response()->json($attachment, 201);
    }

    // Supprimer fichier
    public function destroy($id)
    {
        $attachment = Attachment::findOrFail($id);

        // Autorisation
        if ($attachment->eventRequest->created_by !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Supprimer du storage
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return response()->json(['message' => 'Fichier supprimé']);
    }
}
