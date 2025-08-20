@component('mail::message')
# Nouvelle Invitation

Vous avez été invité à rejoindre **{{ config('app.name') }}**.

**Email :** {{ $invitation->email }}  
**Rôle :** {{ ucfirst($invitation->role ?? 'utilisateur') }}

@component('mail::button', ['url' => route('invitations.accept', $invitation->token)])
Accepter l'invitation
@endcomponent

⚠️ Ce lien expirera le **{{ $invitation->expires_at->format('d/m/Y') }}**.

Merci,  
L'équipe {{ config('app.name') }}
@endcomponent
