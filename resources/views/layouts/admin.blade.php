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
    
    <!-- Admin Specific Styles could go here -->
    <style>
        .admin-page {
            background-color: #f3f4f6; /* Light gray background for admin */
        }
    </style>
</head>
<body class="admin-page">

    <main class="main-content">
        
        <x-navigation title="Administration" />

        <div class="content-wrapper">
            @if(session('success')) <x-alert type="success">{{ session('success') }}</x-alert> @endif
            @if(session('error'))   <x-alert type="error">{{ session('error') }}</x-alert>   @endif

            @yield('content')
        </div>

        <x-footer />

    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>