@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Nouveau serveur</h1>
    </div>

    <div class="info-card">
        <form action="{{ route('resources.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Nom :</label>
                <input type="text" name="name" style="width: 100%; padding: 8px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Catégorie :</label>
                <select name="category_id" style="width: 100%; padding: 8px;" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>CPU :</label>
                <input type="text" name="cpu" style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>RAM :</label>
                <input type="text" name="ram" style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" class="btn btn-filter">Enregistrer</button>
        </form>
    </div>
</div>
@endsection
