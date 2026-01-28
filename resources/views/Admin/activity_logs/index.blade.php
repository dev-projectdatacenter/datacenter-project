@extends('layouts.app')

@section('content')

<style>
/* --- VARIABLES --- */
:root {
    --primary: #434861;        /* Bleu Ardoise */
    --accent: #c38854ff;         /* Orange Accent */
    --bg-light: #f8fafc;       /* Gris Perle */
    --white: #ffffff;
    --border: #e2e8f0;
}

/* --- STRUCTURE --- */
.container {
    padding: 40px 20px;
    background-color: var(--bg-light);
    min-height: 100vh;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

h2 {
    color: var(--primary);
    font-weight: 800;
    font-size: 1.8rem;
    margin-bottom: 30px;
    border-left: 5px solid var(--accent);
    padding-left: 15px;
}

/* --- LE TABLEAU (Écrase les attributs HTML) --- */
table {
    width: 100% !important;
    border-collapse: collapse !important; /* Supprime le double trait du border="1" */
    border: none !important;
    background: var(--white);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

/* En-tête */
thead {
    background-color: var(--primary);
}

th {
    color: var(--white) !important;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    padding: 18px !important;
    border: none !important;
    text-align: left;
}

/* Corps du tableau */
td {
    padding: 15px 18px !important;
    border-bottom: 1px solid var(--border) !important;
    border-left: none !important;
    border-right: none !important;
    border-top: none !important;
    color: #4a5568;
    font-size: 0.95rem;
}

/* Coloration de l'ID en orange */
td:first-child {
    font-weight: 700;
    color: var(--accent);
}

/* Effet au survol */
tbody tr:hover {
    background-color: #fffaf5;
    transition: 0.2s;
}

/* Date */
td:last-child {
    color: #718096;
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
    }
}
</style>

<div class="container">
    <h2>Activity Logs</h2>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Action</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user->name ?? 'N/A' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
