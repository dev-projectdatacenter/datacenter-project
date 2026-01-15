@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Bienvenue au Data Center</h1>
    <p style="margin-top: 1rem;">Plateforme de gestion, réservation et suivi des ressources informatiques.</p>
    
    <div style="margin-top: 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div style="padding: 1rem; border: 1px solid #eee; border-radius: 4px;">
            <h3>🔍 Consulter les ressources</h3>
            <p>Accédez au catalogue des serveurs, VMs et équipements réseau disponibles.</p>
            <a href="{{ url('/resources') }}" style="display: inline-block; margin-top: 1rem; color: #3498db; font-weight: bold;">Voir le catalogue &rarr;</a>
        </div>
        
        <div style="padding: 1rem; border: 1px solid #eee; border-radius: 4px;">
            <h3>🔐 Accès réservé</h3>
            <p>Connectez-vous pour effectuer une demande de réservation ou gérer vos équipements.</p>
            <a href="{{ route('login') }}" style="display: inline-block; margin-top: 1rem; color: #2c3e50; font-weight: bold;">Se connecter &rarr;</a>
        </div>
    </div>
</div>
@endsection
