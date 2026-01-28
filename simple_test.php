<?php

// Test simple des rappels
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Test simple des rappels\n";

$now = now();
echo "Heure: $now\n";

// Chercher réservations qui commencent dans 1 heure
$reservations = \App\Models\Reservation::where('status', 'approved')
    ->where('start_date', '>', $now)
    ->where('start_date', '<=', $now->copy()->addHour())
    ->get();

echo "Réservations dans 1 heure: " . $reservations->count() . "\n";

foreach ($reservations as $r) {
    echo "- Reservation #{$r->id}: {$r->start_date}\n";
}

echo "Test terminé\n";
?>
