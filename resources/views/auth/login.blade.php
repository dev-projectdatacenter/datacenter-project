{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Connexion')

@section('content')
<div class="login-container">
    <div class="login-card">
        <h2>Connexion</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group-check">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Se souvenir de moi</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        
        <div class="login-links">
            <a href="{{ route('register') }}">Créer un compte</a>
            <!-- Lien pour reset password sera ajouté plus tard -->
        </div>
    </div>
</div>
@endsection