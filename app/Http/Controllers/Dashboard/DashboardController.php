<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Page d'accueil du dashboard
    public function index()
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'Bienvenue sur votre tableau de bord',
            'user' => $user,
        ]);
    }
}
