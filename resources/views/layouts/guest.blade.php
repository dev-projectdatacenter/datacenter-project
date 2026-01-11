<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Data Center Manager') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        .guest-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: var(--bg-body);
        }
        
        .guest-card {
            width: 100%;
            max-width: 420px;
            background: var(--bg-card);
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
        }

        .guest-logo {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="guest-layout">
        <div class="guest-logo">
            🔌
        </div>

        <div class="guest-card">
            @yield('content')
        </div>

        <p class="mt-3 text-muted text-small">
            &copy; 2024 DataCenter Manager
        </p>
    </div>

</body>
</html>