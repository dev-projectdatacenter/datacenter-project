@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="color: #0f1e3f;">Planning des Maintenances</h1>
        @can('create', App\Models\Maintenance::class)
            <a href="{{ route('maintenances.create') }}" class="btn-primary" style="background: #424665; color: white; padding: 0.5rem 1rem; border-radius: 10px; text-decoration: none; font-weight: bold;">+ Planifier une intervention</a>
        @endcan
    </div>

    @if(session('success'))
        <div style="background: #fdfaf5; color: #0f1e3f; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #997953;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 8px; border: 1px solid #e2d1b9; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #7c89a7ff; color: white;">
                <tr>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;">Période</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;">Ressource</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;">Raison / Détails</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953; width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenances as $maintenance)
                <tr style="border-bottom: 1px solid #e2d1b9;">
                    <td style="padding: 1rem;">
                        <span style="display: block; font-weight: bold; color: #0f1e3f;">Du {{ \Carbon\Carbon::parse($maintenance->start_date)->format('d/m/Y H:i') }}</span>
                        <span style="font-size: 0.85rem; color: #997953;">Au {{ \Carbon\Carbon::parse($maintenance->end_date)->format('d/m/Y H:i') }}</span>
                    </td>
                    <td style="padding: 1rem;">
                        <strong style="color: #0f1e3f;">{{ $maintenance->resource->name ?? 'N/A' }}</strong><br>
                        <small style="color: #213a56;">{{ $maintenance->resource->category->name ?? '' }}</small>
                    </td>
                    <td style="padding: 1rem; color: #213a56;">
                        {{ $maintenance->reason }}
                    </td>
                    <td style="padding: 1rem;">
                        @can('delete', $maintenance)
                            <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST" onsubmit="return confirm('Annuler cette maintenance ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 0; font-size: 0.9rem;">🗑️ Annuler</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #997953;">Aucune maintenance planifiée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection