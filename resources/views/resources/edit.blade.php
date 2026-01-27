@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Editer : {{ $resource->name }}</h1>
    </div>

    <div class="info-card">
        <form action="{{ route('resources.update', $resource) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 15px;">
                <label>Nom :</label>
                <input type="text" name="name" value="{{ $resource->name }}" style="width: 100%; padding: 8px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Catégorie :</label>
                <select name="category_id" style="width: 100%; padding: 8px;" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $resource->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Statut :</label>
                <select name="status" style="width: 100%; padding: 8px;" required>
                    <option value="available" {{ $resource->status == 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="busy" {{ $resource->status == 'busy' ? 'selected' : '' }}>Occupée</option>
                    <option value="maintenance" {{ $resource->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="out_of_service" {{ $resource->status == 'out_of_service' ? 'selected' : '' }}>Hors service</option>
                </select>
            </div>
            @can('admin')
            <div style="margin-bottom: 15px;">
                <label>Responsable technique (Tech Manager) :</label>
                <select name="managed_by" style="width: 100%; padding: 8px;">
                    <option value="">-- Aucun --</option>
                    @foreach($techManagers as $tech)
                        <option value="{{ $tech->id }}" {{ $resource->managed_by == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                    @endforeach
                </select>
            </div>
            @endcan
            <div style="margin-bottom: 15px;">
                <label>CPU :</label>
                <input type="text" name="cpu" value="{{ $resource->cpu }}" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>RAM :</label>
                <input type="text" name="ram" value="{{ $resource->ram }}" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Stockage :</label>
                <input type="text" name="storage" value="{{ $resource->storage }}" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>OS :</label>
                <input type="text" name="os" value="{{ $resource->os }}" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Localisation :</label>
                <input type="text" name="location" value="{{ $resource->location }}" style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" class="btn btn-primary" style="background: #3498db; width: 100%;">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
