@extends('layouts.admin')

@section('title', 'Gestion des Maintenances')

@section('content')
<div class="admin-section">
    <div class="section-header">
        <h1>🔧 Gestion des Maintenances</h1>
        <a href="{{ route('admin.maintenances.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Planifier une maintenance
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>📅 Maintenances Planifiées</h3>
        </div>
        <div class="card-body">
            @if($maintenances->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ressource</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                                <th>Motif</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenances as $maintenance)
                                <tr>
                                    <td>
                                        <strong>{{ $maintenance->resource->name }}</strong>
                                        <br><small class="text-muted">{{ $maintenance->resource->category->name }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($maintenance->start_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($maintenance->end_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $maintenance->reason ?: 'Non spécifié' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.maintenances.show', $maintenance) }}" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.maintenances.edit', $maintenance) }}" 
                                               class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.maintenances.destroy', $maintenance) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Supprimer cette maintenance?')"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-tools fa-3x text-muted"></i>
                    <h4>Aucune maintenance planifiée</h4>
                    <p class="text-muted">Commencez par planifier une période de maintenance.</p>
                    <a href="{{ route('admin.maintenances.create') }}" class="btn btn-primary">
                        Planifier une maintenance
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
