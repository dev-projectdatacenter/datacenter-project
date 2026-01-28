@extends('layouts.admin')

@section('title', 'Logs d\'activité')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Logs d'activité</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
            ← Retour au dashboard
        </a>
    </div>

    <div class="admin-card">
        <div class="logs-header">
            <h3>Historique des actions système</h3>
            <p>Consultez les dernières activités des utilisateurs</p>
        </div>

        <div class="logs-list">
            @forelse($logs as $log)
                <div class="log-item">
                    <div class="log-header">
                        <div class="log-user">
                            <strong>{{ $log->user->name ?? 'Système' }}</strong>
                            <span class="log-email">{{ $log->user->email ?? 'system@datacenter.com' }}</span>
                        </div>
                        <div class="log-time">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                    <div class="log-content">
                        <div class="log-action">
                            <span class="action-badge">{{ $log->action ?? 'Action' }}</span>
                        </div>
                        <div class="log-description">
                            {{ $log->description ?? 'Aucune description disponible' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-logs">
                    <div class="empty-icon">📋</div>
                    <h3>Aucun log d'activité</h3>
                    <p>Les activités des utilisateurs apparaîtront ici.</p>
                </div>
            @endforelse
        </div>

        @if($logs->hasPages())
            <div class="pagination-wrapper">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.logs-header {
    padding: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.logs-header h3 {
    color: #2d3748;
    margin-bottom: 5px;
}

.logs-header p {
    color: #64748b;
    margin: 0;
}

.logs-list {
    max-height: 600px;
    overflow-y: auto;
}

.log-item {
    padding: 15px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: background-color 0.2s ease;
}

.log-item:hover {
    background-color: #f8fafc;
}

.log-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.log-user strong {
    color: #2d3748;
    font-size: 14px;
}

.log-email {
    color: #64748b;
    font-size: 12px;
    margin-left: 8px;
}

.log-time {
    color: #94a3b8;
    font-size: 12px;
    font-family: monospace;
}

.log-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.action-badge {
    background: #e0e7ff;
    color: #3730a3;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.log-description {
    color: #475569;
    font-size: 13px;
    flex: 1;
}

.empty-logs {
    text-align: center;
    padding: 60px 20px;
    color: #94a3b8;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 15px;
}

.empty-logs h3 {
    color: #64748b;
    margin-bottom: 5px;
}

.pagination-wrapper {
    padding: 20px;
    display: flex;
    justify-content: center;
}
</style>
@endpush
@endsection
