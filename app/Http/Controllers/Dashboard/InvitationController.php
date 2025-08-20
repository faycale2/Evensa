<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Instance;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\InvitationMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;



class InvitationController extends BaseController
{
    public function __construct()
    {
        $this->middleware('throttle:10,1')->only('store');
    }

    public function index()
    {
        return view('dashboard.invitations.index', [
            'invitations' => Invitation::with('instance')->latest()->paginate(10),
            'instances' => Instance::all()
        ]);
    }

    public function create()
    {
        return view('emails.invitation', [
            'instances' => Instance::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:invitations,email|unique:users,email',
            'instance_id' => 'required|exists:instances,id',
            'role' => 'required|in:professeur,etudiant'
        ]);

        try {
            $invitation = Invitation::create([
                'email'       => $validated['email'],
                'token'       => Str::random(60),
                'role'        => $validated['role'],
                'instance_id' => $validated['instance_id'],
                'expires_at'  => now()->addDays(7),
            ]);

            Mail::to($validated['email'])->send(new InvitationMail($invitation));
            Log::info("Invitation créée pour {$validated['email']}");

            return redirect()->route('dashboard.invitations.index')
                             ->with('success', 'Invitation envoyée avec succès !');
        } catch (\Exception $e) {
            Log::error("Erreur création invitation : ".$e->getMessage());
            return back()->withInput()->with('error', 'Erreur lors de la création de l\'invitation');
        }
    }

    public function destroy(Invitation $invitation)
    {
        try {
            $invitation->delete();
            Log::info("Invitation annulée pour {$invitation->email}");
            return back()->with('success', 'Invitation annulée avec succès');
        } catch (\Exception $e) {
            Log::error("Erreur suppression invitation : ".$e->getMessage());
            return back()->with('error', 'Erreur lors de l\'annulation');
        }
    }

    public function accept(Request $request)
    {
        $token=$request->route('token');
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            return redirect()->route('/login')->with('error', 'Invitation invalide.');
        }

        if ($invitation->isExpired()) {
            $invitation->delete();
            return redirect()->route('login')->with('error', 'Cette invitation a expiré.');
        }

        if ($invitation->isUsed()) {
            return redirect()->route('login')->with('error', 'Cette invitation a déjà été utilisée.');
        }

        return view('auth.register', ['invitation' => $invitation]);
    }


    
        
    

    }
