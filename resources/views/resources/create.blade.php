@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Nouveau serveur</h1>
    </div>

    <div class="info-card">
        <form action="{{ route('resources.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Nom :</label>
                <input type="text" name="name" style="width: 100%; padding: 8px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Catégorie :</label>
                <select name="category_id" style="width: 100%; padding: 8px;" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Statut :</label>
                <select name="status" style="width: 100%; padding: 8px;" required>
                    <option value="available">Disponible</option>
                    <option value="busy">Occupée</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="out_of_service">Hors service</option>
                </select>
            </div>
            @can('admin')
            <div style="margin-bottom: 15px;">
                <label>Responsable technique (Tech Manager) :</label>
                <select name="managed_by" style="width: 100%; padding: 8px;">
                    <option value="">-- Aucun --</option>
                    @foreach($techManagers as $tech)
                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                    @endforeach
                </select>
            </div>
            @endcan
            <div style="margin-bottom: 15px;">
                <label>CPU :</label>
                <input type="text" name="cpu" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>RAM :</label>
                <input type="text" name="ram" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Bande Passante :</label>
                <input type="text" name="bandwidth" style="width: 100%; padding: 8px;" placeholder="ex: 1 Gbps">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Stockage :</label>
                <input type="text" name="storage" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>OS :</label>
                <input type="text" name="os" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Localisation :</label>
                <input type="text" name="location" style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" class="btn btn-primary" style="background: #3498db; width: 100%;">Enregistrer</button>
        </form>
    </div>
</div>
@endsection
