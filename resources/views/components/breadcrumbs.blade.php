@props(['paths' => []])

<nav class="breadcrumbs" aria-label="Breadcrumb">
    <ol>
        <li>
            <a href="{{ url('/') }}" class="home-icon">
                <i class="fas fa-home"></i>
            </a>
        </li>
        @foreach($paths as $label => $url)
            <li>
                <span class="separator">/</span>
                @if($loop->last)
                    <span class="current" aria-current="page">{{ $label }}</span>
                @else
                    <a href="{{ $url }}">{{ $label }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>