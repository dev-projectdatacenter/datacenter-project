<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Tech Manager</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            padding: 20px;
        }

        .box {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
        }

        th {
            background: #ddd;
        }

        .warning {
            background: #fff3cd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .info {
            background: #d1ecf1;
            padding: 10px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 10px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 10px;
        }

        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-warning {
            background: #ffc107;
            color: black;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }
    </style>
</head>

<body>

<h1>Dashboard Tech Manager</h1>
<p>Bienvenue <strong>{{ $user->name }}</strong></p>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="error">{{ session('error') }}</div>
@endif

<div class="box">
    <h3>Statistiques Ressources</h3>
    <p>Total ressources: {{ $statistics['totalResources'] }}</p>
    <p>Ressources disponibles: {{ $statistics['availableResources'] }}</p>
    <p>Ressources en maintenance: {{ $statistics['totalResources'] - $statistics['availableResources'] - $statistics['criticalResources'] }}</p>
    <p>Ressources occupées: {{ $statistics['criticalResources'] }}</p>
    <p>Total réservations: {{ $statistics['totalReservations'] }}</p>
    <p>Total utilisateurs: {{ $statistics['totalUsers'] }}</p>
</div>

<div class="box">
    <h3>Alertes</h3>
    @if($statistics['pendingReservations'] > 0)
        <div class="warning">
            {{ $statistics['pendingReservations'] }} réservations en attente de validation
        </div>
    @endif

    @if($statistics['criticalResources'] > 0)
        <div class="info">
            {{ $statistics['criticalResources'] }} ressources actuellement occupées
        </div>
    @endif

    @if($incidents->count() > 0)
        <div class="warning">
            <strong>Incidents ouverts:</strong>
            <ul>
                @foreach($incidents as $incident)
                    <li>
                        {{ $incident->description }} - Ressource: {{ $incident->resource->name ?? 'N/A' }} - Utilisateur: {{ $incident->user->name ?? 'N/A' }}
                        <form method="POST" action="{{ route('incident.delete', $incident->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet incident ?')">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<div class="box">
    <h3>Réservations par statut</h3>

    <table>
        <tr>
            <th>Statut</th>
            <th>Total</th>
        </tr>

        @foreach($statistics['reservationsByStatus'] as $status => $count)
        <tr>
            <td>{{ ucfirst($status) }}</td>
            <td>{{ $count }}</td>
        </tr>
        @endforeach

    </table>
</div>

<div class="box">
    <h3>Toutes les réservations</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Ressource</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Statut</th>
        </tr>
        @foreach($reservations as $reservation)
        <tr>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->user->name ?? 'N/A' }}</td>
            <td>{{ $reservation->resource->name ?? 'N/A' }}</td>
            <td>{{ $reservation->start_date }}</td>
            <td>{{ $reservation->end_date }}</td>
            <td>{{ ucfirst($reservation->status) }}</td>
        </tr>
        @endforeach
    </table>
</div>

<div class="box">
    <h3>Gestion des ressources</h3>
    <div style="margin-bottom: 15px;">
        <button class="btn btn-primary">➕ Ajouter ressource</button>
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        @foreach($resources as $resource)
        <tr>
            <td>{{ $resource->id }}</td>
            <td>{{ $resource->name }}</td>
            <td>{{ $resource->category->name ?? 'N/A' }}</td>
            <td>{{ ucfirst($resource->status) }}</td>
            <td>
                <button class="btn btn-info">✏ Modifier</button>
                <form method="POST" action="{{ route('resource.maintenance', $resource->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        @if($resource->status === 'maintenance')
                            Retirer de maintenance
                        @else
                            Mettre en maintenance
                        @endif
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

</body>
</html>
