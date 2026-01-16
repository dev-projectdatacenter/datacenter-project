<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Invité - Data Center</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h1 { margin-bottom: 20px; }
        h2 { margin-top: 40px; margin-bottom: 20px; }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .status-available { background: #28a745; }
        .status-busy { background: #dc3545; }
        .status-maintenance { background: #ffc107; color: black; }
        .status-critical { background: #6f42c1; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
        th { background: #eee; }
        .filters { margin-bottom: 20px; }
        .filters label { margin-right: 10px; font-weight: bold; }
        .filters select { padding: 5px; margin-right: 20px; }
    </style>
</head>
<body>
    <h1>Dashboard Invité - Vue Globale des Ressources</h1>
    <p>Bienvenue en mode visiteur. Vous pouvez consulter les ressources disponibles en lecture seule.</p>

    <!-- Vue globale des ressources -->
    <h2>Vue globale des ressources (Consultation uniquement)</h2>
    <p>Liste de toutes les ressources disponibles (serveurs, VM, stockage, équipements réseau)</p>

    <div class="filters">
        <label>Filtrer par catégorie:</label>
        <select id="categoryFilter">
            <option value="">Toutes</option>
            @foreach($resources->pluck('category.name')->unique() as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>

        <label>Filtrer par état:</label>
        <select id="statusFilter">
            <option value="">Tous</option>
            <option value="available">Disponible</option>
            <option value="busy">Occupée</option>
            <option value="maintenance">Maintenance</option>
            <option value="critical">Critique</option>
        </select>
    </div>

    <table id="resourcesTable">
        <thead>
            <tr>
                <th>Nom de la ressource</th>
                <th>Catégorie</th>
                <th>Caractéristiques techniques</th>
                <th>État actuel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
                <tr data-category="{{ $resource->category->name }}" data-status="{{ $resource->status }}">
                    <td>{{ $resource->name }}</td>
                    <td>{{ $resource->category->name }}</td>
                    <td>
                        CPU: {{ $resource->cpu }}<br>
                        RAM: {{ $resource->ram }}<br>
                        Stockage: {{ $resource->storage }}<br>
                        OS: {{ $resource->os }}
                    </td>
                    <td>
                        @php
                            $statusLabels = [
                                'available' => 'Disponible',
                                'busy' => 'Occupée',
                                'maintenance' => 'Maintenance',
                                'critical' => 'Critique'
                            ];
                            $statusClass = 'status-' . $resource->status;
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $statusLabels[$resource->status] ?? $resource->status }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const tableRows = document.querySelectorAll('#resourcesTable tbody tr');

        function filterTable() {
            const category = categoryFilter.value;
            const status = statusFilter.value;

            tableRows.forEach(row => {
                const rowCategory = row.dataset.category;
                const rowStatus = row.dataset.status;
                let show = true;

                if (category && rowCategory !== category) show = false;
                if (status && rowStatus !== status) show = false;

                row.style.display = show ? '' : 'none';
            });
        }

        categoryFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);
    </script>
</body>
</html>
