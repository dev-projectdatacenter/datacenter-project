@extends('layouts.admin')

@section('title', 'Détails du log - ' . $filename)

@section('content')

<style>
/* --- VARIABLES --- */
:root {
    --primary: #434861;        /* Bleu Ardoise */
    --accent: #e09858ff;         /* Orange Accent */
    --bg-light: #f3f4f6;       /* Gris Perle */
    --white: #ffffff;
    --border: #edf2f7;
    --code-bg: #1e1e1e;        /* Fond sombre pour le log style VS Code */
    --code-text: #d4d4d4;
}

/* --- STRUCTURE & ESPACEMENTS --- */
.container-fluid {
    padding: 30px !important;
    background-color: var(--bg-light);
    min-height: 100vh;
    font-family: 'Inter', system-ui, sans-serif;
}

.mb-4 {
    margin-bottom: 1.5rem !important;
}

/* --- HEADER --- */
h1 {
    color: var(--primary);
    font-weight: 800;
    font-size: 1.6rem;
    margin: 0;
}

/* --- CARTE DU LOG --- */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    background: var(--white);
    overflow: hidden; /* Pour que le pre respecte les bords arrondis */
    margin-top: 20px;
}

/* --- ZONE DE TEXTE (LOG CONTENT) --- */
pre {
    margin: 0;
    padding: 25px !important;
    font-family: 'Fira Code', 'Cascadia Code', 'Monaco', monospace;
    font-size: 0.9rem;
    line-height: 1.6;
    color: var(--code-text);
    background-color: var(--code-bg) !important; /* On force un thème sombre pour le log */
    border-radius: 0;
    white-space: pre-wrap;       /* Retour à la ligne automatique */
    word-break: break-all;
    border-top: 4px solid var(--accent); /* Rappel orange sur le haut du bloc de code */
}

/* Scrollbar personnalisée pour la zone de code */
pre::-webkit-scrollbar {
    width: 10px;
}
pre::-webkit-scrollbar-track {
    background: #2d2d2d;
}
pre::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 5px;
}

/* --- BOUTON RETOUR --- */
.btn-outline-secondary {
    border: 2px solid var(--primary);
    color: var(--primary);
    background: transparent;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-outline-secondary:hover {
    background: var(--primary);
    color: var(--white);
}

@media (max-width: 768px) {
    .d-flex {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start !important;
    }
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Détails du log : {{ $filename }}</h1>
                <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <pre class="p-3 mb-0" style="max-height: 70vh; overflow-y: auto; background-color: #f8f9fa;">{{ $content }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
