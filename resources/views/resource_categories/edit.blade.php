@extends('layouts.app')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="color: #0f1e3f;">Modifier la Catégorie : {{ $category->name }}</h1>
        <a href="{{ route('categories.index') }}" style="color: #997953; text-decoration: none;">&larr; Retour à la liste</a>
    </div>

    @if ($errors->any())
        <div style="background: #fdfaf5; color: #0f1e3f; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #997953;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="background: white; padding: 2rem; border-radius: 8px; border: 1px solid #e2d1b9;">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Nom de la catégorie</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 0.6rem; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">{{ old('description', $category->description) }}</textarea>
            </div>

            <div style="text-align: right;">
                <button type="submit" style="background: #424665; color: white; padding: 0.7rem 2rem; border: none; border-radius: 10px; cursor: pointer; font-weight: bold;">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection