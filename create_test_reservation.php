<?php

// Créer une réservation test pour vérifier le système
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CRÉATION RÉSERVATION TEST ===\n";

$now = now();
echo "Heure actuelle: {$now}\n";

// Créer une réservation qui devrait être "active"
$startTime = $now->copy()->subMinutes(30); // Il y a 30 minutes
$endTime = $now->copy()->addMinutes(30);   // Dans 30 minutes

echo "Création réservation test:\n";
echo "Début: {$startTime}\n";
echo "Fin: {$endTime}\n";

$reservation = new \App\Models\Reservation();
$reservation->user_id = 1; // Adapter selon votre utilisateur
$reservation->resource_id = 1; // Adapter selon votre ressource
$reservation->start_date = $startTime;
$reservation->end_date = $endTime;
$reservation->status = 'approved';
$reservation->justification = 'Réservation test pour mise à jour automatique';
$reservation->save();

echo "Réservation #{$reservation->id} créée avec le statut 'approved'\n";
echo "Cette réservation devrait passer à 'active' immédiatement\n";

echo "\n=== TEST TERMINÉ ===\n";
?>
