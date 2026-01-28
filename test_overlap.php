<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Test de détection d'overlaps ===\n";

// Test 1: Votre scénario exact - périodes différentes
$service = new App\Services\ReservationValidationService();
echo "Test avec ressource ID 4\n";
echo "Première réservation: 29/01/2026 → 30/01/2026 (approuvée)\n";
echo "Deuxième demande: 31/01/2026 → 03/02/2026\n";

$result1 = $service->checkAvailability(4, '2026-01-31 09:00', '2026-02-03 17:00');
echo "Résultat: " . ($result1 ? 'AUTORISÉ ✅' : 'BLOQUÉ ❌') . "\n";

// Test 2: Vérifions s'il y a des réservations existantes
echo "\n=== Réservations existantes pour ressource 4 ===\n";
$reservations = App\Models\Reservation::where('resource_id', 4)
    ->whereIn('status', ['approved', 'pending'])
    ->get();

foreach($reservations as $r) {
    echo "ID: {$r->id}, Début: {$r->start_date}, Fin: {$r->end_date}, Status: {$r->status}\n";
}

echo "\n=== Test de chevauchement direct ===\n";
$result2 = $service->checkAvailability(4, '2026-01-29 10:00', '2026-01-30 16:00');
echo "Test avec dates qui chevauchent: " . ($result2 ? 'AUTORISÉ' : 'BLOQUÉ') . "\n";

echo "=== Fin du test ===\n";
