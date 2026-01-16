@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Gestion des Catégories</h1>
        <a href="{{ route('categories.create') }}" class="btn-primary" style="background: #27ae60; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">+ Nouvelle Catégorie</a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    <div style="background: white; border-radius: 8px; border: 1px solid #ddd; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Nom</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd;">Description</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #ddd; width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem; font-weight: bold;">{{ $category->name }}</td>
                    <td style="padding: 1rem; color: #666;">{{ $category->description ?? 'Aucune description' }}</td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('categories.edit', $category) }}" style="color: #3498db; text-decoration: none; font-size: 0.9rem;">✏️ Modifier</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0; font-size: 0.9rem;">🗑️ Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 2rem; text-align: center; color: #999;">Aucune catégorie trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
