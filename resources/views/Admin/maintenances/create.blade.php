@extends('layouts.admin')

@section('title', 'Planifier une Maintenance')

@section('content')
<div class="admin-section">
    <div class="section-header">
        <h1>🔧 Planifier une Maintenance</h1>
        <a href="{{ route('admin.maintenances.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>📅 Nouvelle Période de Maintenance</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.maintenances.store') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="resource_id">Ressource concernée *</label>
                            <select name="resource_id" id="resource_id" class="form-control" required>
                                <option value="">Sélectionner une ressource</option>
                                @foreach($resources as $resource)
                                    <option value="{{ $resource->id }}">
                                        {{ $resource->name }} ({{ $resource->category->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('resource_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Date de début *</label>
                            <input type="datetime-local" 
                                   name="start_date" 
                                   id="start_date" 
                                   class="form-control" 
                                   required
                                   min="{{ now()->format('Y-m-d\TH:i') }}">
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Date de fin *</label>
                            <input type="datetime-local" 
                                   name="end_date" 
                                   id="end_date" 
                                   class="form-control" 
                                   required>
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reason">Motif de la maintenance</label>
                            <textarea name="reason" 
                                      id="reason" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Décrivez la raison de cette maintenance..."></textarea>
                            @error('reason')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Planifier la maintenance
                    </button>
                    <a href="{{ route('admin.maintenances.index') }}" class="btn btn-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
    });
});
</script>
@endpush
@endsection
