<!DOCTYPE html>
<html>
<head>
    <title>Test DataCenter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"> DataCenter Project - Test</h1>
        
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h4> Base de données connectée avec succès</h4>
            </div>
            <div class="card-body">
                @php
                    try {
                        $dbName = DB::connection()->getDatabaseName();
                        $userCount = DB::table('users')->count();
                        $roleCount = DB::table('roles')->count();
                        $connection = true;
                    } catch (Exception $e) {
                        $connection = false;
                        $error = $e->getMessage();
                    }
                @endphp
                
                @if($connection)
                    <div class="alert alert-success">
                        <strong>Base de données :</strong> {{ $dbName }}<br>
                        <strong>Utilisateurs :</strong> {{ $userCount }}<br>
                        <strong>Rôles :</strong> {{ $roleCount }}
                    </div>
                    
                    <h5>Rôles disponibles :</h5>
                    <ul>
                        @foreach(DB::table('roles')->get() as $role)
                            <li><strong>{{ $role->name }}</strong>: {{ $role->description }}</li>
                        @endforeach
                    </ul>
                    
                    <h5>Utilisateurs de test :</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(DB::table('users')
                                ->join('roles', 'users.role_id', '=', 'roles.id')
                                ->select('users.id', 'users.name', 'users.email', 'roles.name as role_name')
                                ->get() as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger">
                        <strong>Erreur de connexion :</strong> {{ $error }}
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4> Identifiants de test</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Administrateur</h5>
                                <p><strong>Email :</strong> Chayma@gmail.ma</p>
                                <p><strong>Mot de passe :</strong> admin1234</p>
                                <a href="/login" class="btn btn-success">Se connecter</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tech Manager</h5>
                                <p><strong>Email :</strong> tech.manager@datacenter.com</p>
                                <p><strong>Mot de passe :</strong> tech1234</p>
                                <a href="/login" class="btn btn-warning">Se connecter</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Utilisateur</h5>
                                <p><strong>Email :</strong> fatimaZahrae@gmail.ma</p>
                                <p><strong>Mot de passe :</strong> user1234</p>
                                <a href="/login" class="btn btn-info">Se connecter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="/" class="btn btn-primary">Accueil</a>
            <a href="/login" class="btn btn-secondary">Page de connexion</a>
            <a href="/database-status" class="btn btn-success">API Status</a>
        </div>
    </div>
</body>
</html>