<?php

// Test simple pour vérifier que notre page welcome fonctionne
require 'vendor/autoload.php';

// Charger l'environnement
$envFile = '.env';
if (file_exists($envFile)) {
    $content = file_get_contents($envFile);
    $lines = explode("\n", $content);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && !empty(trim($line))) {
            putenv(trim($line));
            $_ENV[substr($line, 0, strpos($line, '='))] = substr($line, strpos($line, '=') + 1);
        }
    }
}

// Créer l'application Laravel
$app = require 'bootstrap/app.php';

// Démarrer le serveur de développement sur un port différent
echo "🚀 Démarrage du serveur de test sur http://127.0.0.1:8001\n";
echo "📝 Test de la page welcome personnalisée\n";
echo "⏹️  Appuyez sur Ctrl+C pour arrêter\n\n";

// Utiliser le serveur PHP intégré
passthru("php -S 127.0.0.1:8001 -t public public/index.php");
