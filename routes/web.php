<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\EventRequestController;
use App\Http\Controllers\Dashboard\InvitationController;
use App\Http\Controllers\Public\AnnouncementController;
use App\Http\Controllers\Public\DocumentController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SupportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CommentController;
use App\Http\Controllers\Dashboard\AttachmentController;
use App\Http\Controllers\Dashboard\DashboardController;



// Routes protégées pour gérer les invitations dans le dashboard


//Pulic routes

Route::get('/',HomeController::class. '@index' );
Route::get('/events',EventRequestController::class. '@publicIndex');
Route::get('/login',LoginController::class. '@showLoginForm');
Route::post('/login',LoginController::class. '@login');
Route::get('/auth/register/{token}', RegisterController::class. '@showRegistrationForm');
Route::post('auth/register/{token}', [RegisterController::class, 'register']);
Route::get('/documents', [DocumentController::class, 'index']);
Route::get('/annonces', [AnnouncementController::class, 'index']);
Route::get('/support', [SupportController::class, 'create']);
Route::post('/support', [SupportController::class, 'store']);

// Demandes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Requests management via Livewire
    Route::get('/dashboard/requests', RequestList::class);
    Route::get('/dashboard/requests/{id}', RequestDetails::class);

    // Invitations (Admin/Directeur only) via Livewire
    Route::get('/dashboard/invitations', InvitationManager::class);
});
























