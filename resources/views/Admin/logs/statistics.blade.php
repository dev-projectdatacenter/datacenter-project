@extends('layouts.admin')

@section('title', 'Statistiques des logs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Statistiques des logs</h1>
                <div>
                    <a href="{{ route('admin.logs.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Exporter CSV
                    </a>
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list"></i> Voir tous les logs
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Nombre total de fichiers</h5>
                            <h2 class="display-4">{{ $stats['total_files'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Espace total utilisé</h5>
                            <h2 class="display-4">{{ number_format($stats['total_size'] / 1024, 2) }} Ko</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Moyenne par fichier</h5>
                            <h2 class="display-4">
                                @if($stats['total_files'] > 0)
                                    {{ number_format($stats['total_size'] / $stats['total_files'] / 1024, 2) }} Ko
                                @else
                                    0 Ko
                                @endif
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Détails des fichiers de log</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom du fichier</th>
                                    <th>Taille</th>
                                    <th>Dernière modification</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['files'] as $file)
                                    <tr>
                                        <td>{{ $file['name'] }}</td>
                                        <td>{{ number_format($file['size'] / 1024, 2) }} Ko</td>
                                        <td>{{ $file['last_modified'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Aucun fichier de log trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
