@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
   
    <div class="card guest-container" style="max-width: 400px; margin: 50px auto;">
        
        <h2 class="text-center mb-2" style="color: var(--delft-blue);">Connexion</h2>

        @if ($errors->any())
           
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="form-control">
            </div>

            <div class="mt-2">
          
                   <button type="submit" style="width: 100%; padding: 12px; background: #424665;; color: white; border: none; border-radius: 100px; cursor: pointer;">
                    Se connecter
                </button>
            </div>

            <div class="text-center mt-2">
            
                <p>Pas encore de compte? <a href="{{ route('register') }}" style="color: #997953; font-weight: 600;">S'inscrire</a></p>
                <p><a href="{{ route('password.request') }}" style="color: var(--text-muted); font-size: 0.875rem;">Mot de passe oublié?</a></p>
            </div>
        </form>
    </div>
@endsection