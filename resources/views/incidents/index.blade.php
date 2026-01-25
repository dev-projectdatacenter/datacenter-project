@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Liste des Incidents</h1>
        <a href="{{ route('incidents.create') }}" class="btn btn-primary" style="background: #e67e22; border: none;">+ Signaler un Incident</a>
    </div>

    <div class="table-container">
        <table class="resource-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ressource</th>
                    <th>Description</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $incident)
                    <tr>
                        <td>{{ $incident->created_at->format('d/m/Y') }}</td>
                        <td>{{ $incident->resource->name ?? 'N/A' }}</td>
                        <td>{{ $incident->description }}</td>
                        <td>
                            <span class="status-badge status-{{ $incident->status == 'open' ? 'maintenance' : 'available' }}">
                                {{ $incident->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
