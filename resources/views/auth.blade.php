@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow-md rounded p-6">
    <h2 class="text-xl font-bold mb-4">Créer un compte</h2>

    <form method="POST" action="{{ route('invitation.register', $invitation->token) }}">
        @csrf

        <div class="mb-4">
            <label>Email</label>
            <input type="email" value="{{ $invitation->email }}" readonly
                   class="w-full border p-2 rounded bg-gray-100">
        </div>

        <div class="mb-4">
            <label>Rôle</label>
            <input type="text" value="{{ ucfirst($invitation->role) }}" readonly
                   class="w-full border p-2 rounded bg-gray-100">
        </div>

        <div class="mb-4">
            <label>Mot de passe</label>
            <input type="password" name="password" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">S'inscrire</button>
    </form>
</div>
@endsection
