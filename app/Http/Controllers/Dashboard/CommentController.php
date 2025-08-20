<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\Comment;
use App\Models\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    // Ajouter un commentaire
    public function store(Request $request, $eventId)
    {
        $event = EventRequest::findOrFail($eventId);

        $comment = Comment::create([
            'content' => $request->validate(['content' => 'required|string'])['content'],
            'event_request_id' => $event->id,
            'user_id' => Auth::id(),
        ]);

        return response()->json($comment, 201);
    }

    // Supprimer un commentaire (seulement auteur ou admin)
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé']);
    }
}
