@extends('layouts.guest')

@section('content')
    <h2 class="text-center mb-4">Connexion</h2>

    <form>
        <div class="form-group">
            <label class="form-label">Adresse Email</label>
            <input type="email" class="form-control" placeholder="nom@datacenter.ma">
        </div>

        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" class="form-control" placeholder="••••••••">
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" class="form-check-input" id="remember">
            <label for="remember">Se souvenir de moi</label>
        </div>

        <button type="button" class="btn btn-primary w-100">
            Se connecter
        </button>
    </form>
    
    <div class="text-center mt-3">
        <a href="#" class="text-small text-primary">Mot de passe oublié ?</a>
    </div>
@endsection