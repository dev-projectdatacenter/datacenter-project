@extends('layouts.admin')

@section('title', 'Détails du log - ' . $filename)

@section('content')
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
