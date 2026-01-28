@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header" style="border-bottom: 2px solid #997953; margin-bottom: 2rem; padding-bottom: 1rem;">
        <h1 style="color: #0f1e3f;">Editer : {{ $resource->name }}</h1>
    </div>

    <div class="info-card" style="background: white; padding: 2rem; border: 1px solid #e2d1b9; border-radius: 8px;">
        <form action="{{ route('resources.update', $resource) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">Nom :</label>
                <input type="text" name="name" value="{{ $resource->name }}" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">Catégorie :</label>
                <select name="category_id" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px; background: #fdfaf5; color: #0f1e3f;" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $resource->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">Statut :</label>
                <select name="status" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px; background: #fdfaf5; color: #0f1e3f;" required>
                    <option value="available" {{ $resource->status == 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="busy" {{ $resource->status == 'busy' ? 'selected' : '' }}>Occupée</option>
                    <option value="maintenance" {{ $resource->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            @can('admin')
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">Responsable technique (Tech Manager) :</label>
                <select name="managed_by" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px; background: #fdfaf5; color: #0f1e3f;">
                    <option value="">-- Aucun --</option>
                    @foreach($techManagers as $tech)
                        <option value="{{ $tech->id }}" {{ $resource->managed_by == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                    @endforeach
                </select>
            </div>
            @endcan
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">CPU :</label>
                <input type="text" name="cpu" value="{{ $resource->cpu }}" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">RAM :</label>
                <input type="text" name="ram" value="{{ $resource->ram }}" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">Bande Passante :</label>
                <input type="text" name="bandwidth" value="{{ $resource->bandwidth }}" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px;" placeholder="ex: 1 Gbps">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">Stockage :</label>
                <input type="text" name="storage" value="{{ $resource->storage }}" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">OS :</label>
                <input type="text" name="os" value="{{ $resource->os }}" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="color: #0f1e3f; font-weight: bold;">Localisation :</label>
                <input type="text" name="location" value="{{ $resource->location }}" style="width: 100%; padding: 8px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>
            <button type="submit" class="btn btn-primary text-center mt-2" style="background: #424665 color: white; width: 15%; padding: 10px; border: none; border-radius: 10px; font-weight: bold; cursor: pointer;">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection