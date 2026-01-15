@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Gestion des Incidents</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('resources.index') }}" style="color: #666; text-decoration: none; padding-top: 0.5rem;">&larr; Retour aux Ressources</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 8px; border: 1px solid #ddd; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Date</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Ressource</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Description</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Statut</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd; width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incidents as $incident)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem; font-size: 0.9rem; color: #666;">
                        {{ $incident->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td style="padding: 1rem;">
                        <strong>{{ $incident->resource->name ?? 'N/A' }}</strong><br>
                        <small style="color: #666;">{{ $incident->resource->category->name ?? '' }}</small>
                    </td>
                    <td style="padding: 1rem;">
                        {{ Str::limit($incident->description, 50) }}
                    </td>
                    <td style="padding: 1rem;">
                        @if($incident->status == 'open')
                            <span style="background: #fde2e2; color: #c53030; padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold;">Ouvert</span>
                        @else
                            <span style="background: #def7ec; color: #03543f; padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold;">Résolu</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <a href="{{ route('incidents.show', $incident) }}" style="color: #3498db; text-decoration: none; font-size: 0.9rem; font-weight: bold;">👁️ Gérer</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #999;">Aucun incident signalé pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
