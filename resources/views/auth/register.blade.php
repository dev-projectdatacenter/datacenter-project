@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: white;">
    <h2 style="text-align: center; margin-bottom: 30px;">Inscription</h2>
    
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom complet</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="phone" style="display: block; margin-bottom: 5px; font-weight: bold;">Téléphone (optionnel)</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="department" style="display: block; margin-bottom: 5px; font-weight: bold;">Département</label>
            <input type="text" id="department" name="department" value="{{ old('department') }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="role_requested" style="display: block; margin-bottom: 5px; font-weight: bold;">Rôle demandé</label>
            <select id="role_requested" name="role_requested" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">Sélectionner un rôle</option>
                <option value="user">Utilisateur</option>
                <option value="tech_manager">Responsable technique</option>
                <option value="admin">Administrateur</option>
                <option value="invite">Invité</option>
            </select>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="motivation" style="display: block; margin-bottom: 5px; font-weight: bold;">Motivation</label>
            <textarea id="motivation" name="motivation" rows="3" required
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('motivation') }}</textarea>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Mot de passe</label>
            <input type="password" id="password" name="password" required minlength="8"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: bold;">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <button type="submit" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                S'inscrire
            </button>
        </div>
        
        <div style="text-align: center;">
            <p>Déjà un compte? <a href="{{ route('login') }}" style="color: #007bff;">Se connecter</a></p>
        </div>
    </form>
</div>
@endsection
