<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class HomeController extends Controller {
    public function index() {
        return view('welcome'); // Vue accueil avec slogan + aperçu
    }
}
