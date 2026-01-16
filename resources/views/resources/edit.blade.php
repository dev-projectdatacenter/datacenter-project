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
                <label>Statut :</label>
                <select name="status" style="width: 100%; padding: 8px;">
                    <option value="available" {{ $resource->status == 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="busy" {{ $resource->status == 'busy' ? 'selected' : '' }}>Occupée</option>
                    <option value="maintenance" {{ $resource->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <button type="submit" class="btn btn-filter">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
