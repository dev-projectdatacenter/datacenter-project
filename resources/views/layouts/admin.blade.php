<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Administration - Data Center' }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles de Chaymae -->
    <link rel="stylesheet" href="{{ asset('css/reservations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!-- Admin Specific Styles could go here -->
    <style>
        .admin-page {
            background-color: #f3f4f6; /* Light gray background for admin */
        }
    </style>
</head>
<body class="admin-page">

    <main class="main-content">
        
        @include('components.navigation', ['title' => 'Administration'])

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success" style="background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-size: 1.2em;"><i class="fas fa-check-circle"></i></span>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-size: 1.2em;"><i class="fas fa-exclamation-circle"></i></span>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </div>

        @include('components.footer')

    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>