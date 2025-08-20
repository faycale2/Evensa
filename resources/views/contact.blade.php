<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Support - Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        form input, form textarea {
            display: block;
            width: 300px;
            margin-bottom: 15px;
            padding: 8px;
        }
        button {
            padding: 10px 20px;
            cursor: pointer;
        }
        .success {
            color: green;
            margin-bottom: 20px;
        }
        .errors {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Formulaire de test Support</h1>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <form method="POST" action="{{ url('/support') }}">
        @csrf
        <input type="text" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
        <input type="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
        <textarea name="message" placeholder="Votre message" required>{{ old('message') }}</textarea>
        <button type="submit">Envoyer</button>
    </form>
	 

</body>
</html>
