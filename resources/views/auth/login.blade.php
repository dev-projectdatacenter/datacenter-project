@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: white;">
    <h2 style="text-align: center; margin-bottom: 30px;">Connexion</h2>
    
    @if ($errors->has('email'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            {{ $errors->first('email') }}
        </div>
    @endif

    @if ($errors->has('password'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            {{ $errors->first('password') }}
        </div>
    @endif

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            <h4 style="margin: 0 0 10px 0; font-size: 16px;">Succès!</h4>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Mot de passe</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <button type="submit" style="width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Se connecter
            </button>
        </div>
        
        <div style="text-align: center;">
            <p>Pas encore de compte? <a href="{{ route('register') }}" style="color: #007bff;">S'inscrire</a></p>
            <p><a href="{{ route('password.request') }}" style="color: #007bff;">Mot de passe oublié?</a></p>
        </div>
    </form>
</div>
@endsection
