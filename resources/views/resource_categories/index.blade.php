@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="color: #0f1e3f;">
            @can('admin')
                Gestion du Catalogue de Ressources
            @else
                Parcourir l'Infrastructure
            @endcan
        </h1>
        @can('admin')
            <a href="{{ route('categories.create') }}" class="btn-primary" style="background: #424665; color: white; padding: 0.5rem 1rem; border-radius: 10px; text-decoration: none;"><i class="fas fa-plus-circle"></i> Nouvelle Catégorie</a>
        @endcan
    </div>

    @if(session('success'))
        <div style="background: #fdfaf5; color: #0f1e3f; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #997953;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fdfaf5; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #e2d1b9;">
            {{ session('error') }}
        </div>
    @endif

    <div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @forelse($categories as $category)
            <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s; border: 1px solid #e2d1b9; box-shadow: 0 4px 6px rgba(15, 30, 63, 0.1); background: white;">
                <div style="height: 180px; background: #fdfaf5; position: relative;">
                    @if($category->image_url)
                        <img src="{{ asset($category->image_url) }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0f1e3f, #997953); color: white; font-size: 3rem;">
                            📂
                        </div>
                    @endif
                    <div style="position: absolute; top: 10px; right: 10px; background: rgba(15, 30, 63, 0.8); color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; backdrop-filter: blur(4px);">
                        {{ $category->resources_count ?? $category->resources->count() }} ressources
                    </div>
                </div>
                <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                    <h3 style="margin: 0 0 0.5rem 0; color: #0f1e3f;">{{ $category->name }}</h3>
                    <p style="color: #666; font-size: 0.9rem; line-height: 1.4; margin-bottom: 1.5rem; flex-grow: 1;">
                        {{ \Illuminate\Support\Str::limit($category->description, 80) }}
                    </p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2d1b9; padding-top: 1rem;">
                        <a href="{{ route('resources.index', ['category_id' => $category->id]) }}" class="btn" style="background: #ba9b75ff; color: white; padding: 8px 15px; border-radius:  10px; text-decoration: none; font-size: 0.9rem;"><i class="fas fa-list-ul"></i> Voir Catalogue</a>
                        
                        <div style="display: flex; gap: 0.5rem;">
                            @can('admin')
                                <a href="{{ route('categories.edit', $category) }}" style="color: #0f1e3f; font-size: 1.2rem;" title="Modifier"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #997953; cursor: pointer; font-size: 1.2rem; padding: 0;" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: white; border-radius: 8px; border: 1px solid #e2d1b9;">
                <p style="color: #997953; font-size: 1.2rem;">Aucune catégorie trouvée.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection