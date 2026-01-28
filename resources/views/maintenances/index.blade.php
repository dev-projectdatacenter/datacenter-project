@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Planning des Maintenances</h1>
        @can('access-tech-panel')
            <a href="{{ route('maintenances.create') }}" class="btn-primary" style="background: #f39c12; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-weight: bold;">+ Planifier une intervention</a>
        @endcan
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
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Période</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Ressource</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Raison / Détails</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd; width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenances as $maintenance)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem;">
                        <span style="display: block; font-weight: bold; color: #2c3e50;">Du {{ \Carbon\Carbon::parse($maintenance->start_date)->format('d/m/Y H:i') }}</span>
                        <span style="font-size: 0.85rem; color: #e67e22;">Au {{ \Carbon\Carbon::parse($maintenance->end_date)->format('d/m/Y H:i') }}</span>
                    </td>
                    <td style="padding: 1rem;">
                        <strong>{{ $maintenance->resource->name ?? 'N/A' }}</strong><br>
                        <small style="color: #666;">{{ $maintenance->resource->category->name ?? '' }}</small>
                    </td>
                    <td style="padding: 1rem; color: #444;">
                        {{ $maintenance->reason }}
                    </td>
                    <td style="padding: 1rem;">
                        @can('access-tech-panel')
                            <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST" onsubmit="return confirm('Annuler cette maintenance ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0; font-size: 0.9rem;"> Annuler</button>
                            </form>
                        @else
                            <span style="color: #999; font-style: italic;">Consultation</span>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #999;">Aucune maintenance planifiée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
