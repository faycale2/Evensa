<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegistrationForm($token) {
    $invitation = Invitation::where('token', $token)
                            ->whereNull('used_at')
                            ->where('expires_at', '>', now())
                            ->firstOrFail();
    return view('auth.register', compact('invitation'));
}


    /**
     * Traite l'inscription
     */
   
    
    public function register(Request $request)
    {
        $token=$request->route('token');
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->isExpired()) {
            $invitation->delete();
            return redirect()->route('auth.login')->with('error', 'Cette invitation a expiré.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'email'       => $invitation->email,
            'password'    => Hash::make($validated['password']),
            'role'        => $invitation->role,
            'instance_id' => $invitation->instance_id,
        ]);

        Auth::login($user);
        

        return redirect()->route('dashboard')->with('success', 'Bienvenue ! Votre compte a été créé.');
    }
}