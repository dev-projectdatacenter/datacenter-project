@extends('layouts.admin')

@section('title', 'Ajouter une Ressource')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Ajouter une Ressource</h1>
        <a href="{{ route('admin.resources.index') }}" class="btn btn-outline">
            ← Retour à la liste
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.resources.store') }}" class="resource-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">
                        Nom de la ressource <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-input" 
                        value="{{ old('name') }}"
                        required
                        placeholder="Ex: Serveur Web Principal"
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">
                        Catégorie <span class="required">*</span>
                    </label>
                    <select id="category_id" name="category_id" class="form-input" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cpu" class="form-label">Processeur</label>
                    <input 
                        type="text" 
                        id="cpu" 
                        name="cpu" 
                        class="form-input" 
                        value="{{ old('cpu') }}"
                        placeholder="Ex: Intel Xeon E5-2680 v4"
                    >
                    @error('cpu')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ram" class="form-label">Mémoire RAM</label>
                    <input 
                        type="text" 
                        id="ram" 
                        name="ram" 
                        class="form-input" 
                        value="{{ old('ram') }}"
                        placeholder="Ex: 32 GB DDR4"
                    >
                    @error('ram')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="storage" class="form-label">Stockage</label>
                    <input 
                        type="text" 
                        id="storage" 
                        name="storage" 
                        class="form-input" 
                        value="{{ old('storage') }}"
                        placeholder="Ex: 1 TB SSD NVMe"
                    >
                    @error('storage')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bandwidth" class="form-label">Bande passante</label>
                    <input 
                        type="text" 
                        id="bandwidth" 
                        name="bandwidth" 
                        class="form-input" 
                        value="{{ old('bandwidth') }}"
                        placeholder="Ex: 1 Gbps"
                    >
                    @error('bandwidth')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="os" class="form-label">Système d'exploitation</label>
                    <input 
                        type="text" 
                        id="os" 
                        name="os" 
                        class="form-input" 
                        value="{{ old('os') }}"
                        placeholder="Ex: Ubuntu 20.04 LTS"
                    >
                    @error('os')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Localisation</label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        class="form-input" 
                        value="{{ old('location') }}"
                        placeholder="Ex: Datacenter Paris, Rack A12"
                    >
                    @error('location')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="status" class="form-label">
                        Statut <span class="required">*</span>
                    </label>
                    <select id="status" name="status" class="form-input" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="form-input" 
                        rows="4"
                        placeholder="Description détaillée de la ressource..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Enregistrer la ressource
                </button>
                <a href="{{ route('admin.resources.index') }}" class="btn btn-outline">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.form-input {
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.required {
    color: #ef4444;
}

.form-error {
    color: #ef4444;
    font-size: 12px;
    margin-top: 4px;
}

.form-actions {
    display: flex;
    gap: 15px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.alert-danger {
    background: #fef2f2;
    color: #991b1b;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    border-left: 4px solid #ef4444;
}

.alert-danger ul {
    margin: 0;
    padding-left: 20px;
}
</style>
@endpush
@endsection
