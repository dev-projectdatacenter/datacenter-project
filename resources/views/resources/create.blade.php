@extends('layouts.app')

@section('content')
<div class="container">
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Ajouter une ressource</h1>
        <a href="{{ route('resources.index') }}" class="btn-secondary">Retour à la liste</a>
    </div>

    @if ($errors->any())
        <div class="alert-error" style="background: #fee; border: 1px solid #f99; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="background: #fff; padding: 2rem; border-radius: 8px; border: 1px solid #ddd;">
        <form action="{{ route('resources.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                {{-- Informations de base --}}
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Nom de la ressource</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ex: Serveur Web 01" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Catégorie</label>
                    <select name="category_id" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Statut</label>
                    <select name="status" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                        <option value="busy" {{ old('status') == 'busy' ? 'selected' : '' }}>Occupée (Réservée)</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>En maintenance</option>
                        <option value="hors_service" {{ old('status') == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Localisation (Physique ou Rack)</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Ex: Rack A-12 / Bureau 4" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #eee;">
            <h3 style="margin-bottom: 1rem;">Spécifications techniques</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Processeur (CPU)</label>
                    <input type="text" name="cpu" value="{{ old('cpu') }}" placeholder="Ex: Intel Xeon 8 cœurs" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Mémoire (RAM)</label>
                    <input type="text" name="ram" value="{{ old('ram') }}" placeholder="Ex: 32GB DDR4" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Stockage</label>
                    <input type="text" name="storage" value="{{ old('storage') }}" placeholder="Ex: 1TB SSD NVMe" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Système d'exploitation (OS)</label>
                    <input type="text" name="os" value="{{ old('os') }}" placeholder="Ex: Ubuntu 22.04 LTS / Windows Server" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1.5rem; text-align: right;">
                <button type="submit" style="background: #27ae60; color: white; padding: 0.7rem 2rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Enregistrer la ressource
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
