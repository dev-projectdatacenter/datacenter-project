<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Data Center') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="guest-page">

    <div class="guest-container">
        <div class="guest-header">
            <div class="logo-icon">
                <i class="fas fa-server"></i>
            </div>
            <h2>Data Center Manager</h2>
        </div>

        <div class="guest-content card">
            @yield('content')
        </div>

        <div class="guest-footer">
            &copy; {{ date('Y') }} - Gestion de Ressources
        </div>
    </div>

</body>
</html>