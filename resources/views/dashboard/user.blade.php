<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utilisateur</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h1 { margin-bottom: 20px; }
        .stat { margin-bottom: 15px; }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .status-pending { background: #fbbf24; color: #92400e; }
        .status-approved { background: #34d399; color: #065f46; }
        .status-active { background: #60a5fa; color: #0c2d6b; }
        .status-rejected { background: #ef4444; color: #7f1d1d; }
        .status-finished { background: #a78bfa; color: #3730a3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Dashboard Utilisateur</h1>
    <p><strong>{{ $user->name }}</strong>, bienvenue sur votre tableau de bord.</p>

    <!-- Statistiques simples -->
    <div class="stat">Total des ressources : {{ $statistics['totalResources'] }}</div>
    <div class="stat">Ressources disponibles : {{ $statistics['availableResources'] }}</div>
    <div class="stat">Total de vos réservations : {{ $statistics['totalReservations'] }}</div>

    <!-- Tableau des réservations par statut -->
    <h2>Vos réservations par statut</h2>
    <table>
        <thead>
            <tr>
                <th>Statut</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Tous les statuts possibles
                $allStatuses = ['pending', 'approved', 'active', 'rejected', 'finished'];
            @endphp

            @foreach ($allStatuses as $status)
                @php
                    $count = $statistics['reservationsByStatus'][$status] ?? 0;
                    $class = 'status-' . $status;
                    $label = ucfirst($status);
                @endphp
                <tr>
                    <td><span class="status-badge {{ $class }}">{{ $label }}</span></td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Notifications et Alertes -->
    <h2>Notifications et Alertes</h2>
    @if(isset($notifications) && $notifications->count() > 0)
        <ul style="background: white; padding: 20px; border-radius: 8px; list-style: none;">
            @foreach($notifications as $notification)
                <li style="padding: 10px 0; border-bottom: 1px solid #eee;">
                    <strong>{{ ucfirst($notification->type) }}:</strong> {{ $notification->message }}
                    <small style="color: #666;">({{ $notification->created_at->diffForHumans() }})</small>
                </li>
            @endforeach
        </ul>
    @else
        <p style="background: white; padding: 20px; border-radius: 8px;">Aucune notification pour le moment.</p>
    @endif
</body>
</html>
