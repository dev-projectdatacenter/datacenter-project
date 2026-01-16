<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Data Center Manager') }}</title>

    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Injection de CSS spécifique (Ouarda) -->
    @stack('styles')
    
    <!-- Chart.js (Pour les statistiques d'Ouarda) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/charts.js') }}" defer></script>
    
    <!-- Injection de JS spécifique (Ouarda) -->
    @stack('scripts')
    
    <style>
        /* Styles additionnels Ouarda */
        .db-error-box { background: #fee; color: #c00; padding: 10px; border: 1px solid #c00; margin: 20px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>
    <div id="app">
        <main class="main-content">
            
            {{-- Nouveau composant de navigation de Fatima/Zahrae --}}
            <x-navigation :title="$title ?? 'Data Center'" />

            <div class="content-wrapper">
                {{-- Messages Flash --}}
                @if(session('success')) 
                    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; border: 1px solid #c3e6cb; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))   
                    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; border: 1px solid #f5c6cb; margin-bottom: 20px;">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Message d'erreur BDD d'Ouarda --}}
                @if(isset($exception) && str_contains($exception->getMessage(), 'SQLSTATE'))
                    <div class="db-error-box">
                        🚨 Attention : Le serveur de base de données (MySQL) est éteint. Lancez MySQL dans XAMPP/Laragon.
                    </div>
                @endif

                @yield('content')
            </div>

            {{-- Nouveau composant footer --}}
            <x-footer />

        </main>
    </div>
</body>
</html>
