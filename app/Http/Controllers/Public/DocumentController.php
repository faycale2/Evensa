<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Document;

class DocumentController extends Controller {
    public function index() {
        $documents = Attachment::all(); // modèle Document pour charte, modèles, etc.
        return view('documents.index', compact('documents'));
    }
}
