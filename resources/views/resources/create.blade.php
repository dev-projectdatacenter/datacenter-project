@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container" style="max-width: 800px; margin: 0 auto; color: #0f1e3f;">
    <div class="resources-header" style="margin-bottom: 2rem; border-bottom: 2px solid #997953; padding-bottom: 1rem;">
        <h1 style="color: #0f1e3f; margin: 0;">Nouveau serveur</h1>
    </div>

    <div class="info-card" style="background: white; padding: 2.5rem; border-radius: 8px; border: 1px solid #e2d1b9; box-shadow: 0 4px 6px -1px rgba(15, 30, 63, 0.1);">
        <form action="{{ route('resources.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                {{-- Nom --}}
                <div style="margin-bottom: 15px; grid-column: span 2;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Nom :</label>
                    <input type="text" name="name" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;" required>
                </div>

                {{-- Catégorie --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Catégorie :</label>
                    <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; background: #fdfaf5; color: #0f1e3f;" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Statut --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Statut :</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; background: #fdfaf5; color: #0f1e3f;" required>
                        <option value="available">Disponible</option>
                        <option value="busy">Occupée</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="out_of_service">Hors service</option>
                    </select>
                </div>
            </div>

            @can('admin')
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Responsable technique (Tech Manager) :</label>
                <select name="managed_by_id" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; background: #fdfaf5; color: #0f1e3f;">
                    <option value="">-- Aucun --</option>
                    @foreach($techManagers as $tech)
                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                    @endforeach
                </select>
            </div>
            @endcan

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; border-top: 1px solid #fdfaf5; padding-top: 20px; margin-top: 10px;">
                {{-- CPU --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">CPU :</label>
                    <input type="text" name="cpu" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
                </div>

                {{-- RAM --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">RAM :</label>
                    <input type="text" name="ram" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
                </div>

                {{-- Bande Passante --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Bande Passante :</label>
                    <input type="text" name="bandwidth" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;" placeholder="ex: 1 Gbps">
                </div>

                {{-- Stockage --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Stockage :</label>
                    <input type="text" name="storage" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
                </div>

                {{-- OS --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">OS :</label>
                    <input type="text" name="os" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
                </div>

                {{-- Localisation --}}
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Localisation :</label>
                    <input type="text" name="location" style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="background: #424665; color: white; border: none; padding: 1rem; width: 100%; border-radius: 10px; font-weight: bold; font-size: 1rem; cursor: pointer; margin-top: 1rem; transition: background 0.3s;">
                Enregistrer la ressource
            </button>
        </form>
    </div>
</div>
@endsection