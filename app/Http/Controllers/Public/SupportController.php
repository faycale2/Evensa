<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Affiche le formulaire de contact
     */
    public function create()
    {
        return view("contact");;
    }

    /**
     * Traite la soumission du formulaire
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'message' => 'required|string|min:10',
    ]);

    // Exemple : ici tu peux envoyer l'email ou stocker en base

    return back()->with('success', 'Message envoyé avec succès !')
                 ->with('data',$validated['name']);
}

}