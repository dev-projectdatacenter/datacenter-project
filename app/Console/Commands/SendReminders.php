<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendReminders extends Command
{
    protected $signature = 'reservations:send-reminders {--minutes=60 : Rappeler les réservations qui commencent dans X minutes}';

    protected $description = 'Envoyer des rappels (notifications internes) avant le début des réservations';

    public function handle(): int
    {
        $minutes = (int) $this->option('minutes');
        if ($minutes <= 0) {
            $minutes = 60;
        }

        $now = now();
        $from = $now->copy()->addMinutes($minutes)->startOfMinute();
        $to = $now->copy()->addMinutes($minutes)->endOfMinute();

        $reservations = Reservation::with('resource')
            ->where('status', 'approved')
            ->whereBetween('start_date', [$from, $to])
            ->get();

        $sent = 0;

        foreach ($reservations as $reservation) {
            // Anti-duplication: on évite d'envoyer le même rappel plusieurs fois.
            // Le champ message est construit dans NotificationService sous la forme "Titre : Message".
            $expectedContains = "Rappel de réservation";

            $alreadySent = Notification::where('user_id', $reservation->user_id)
                ->where('type', 'reservation_reminder')
                ->where('message', 'like', $expectedContains . '%')
                ->where('created_at', '>=', $now->copy()->subHours(6))
                ->exists();

            if ($alreadySent) {
                continue;
            }

            $resourceName = $reservation->resource ? $reservation->resource->name : 'ressource';
            $startDate = $reservation->start_date ? $reservation->start_date->format('d/m/Y H:i') : '';

            try {
                NotificationService::reservationReminder(
                    $reservation->user_id,
                    $resourceName,
                    $startDate,
                    $reservation->id
                );
                $sent++;
            } catch (\Exception $e) {
                \Log::error('Erreur rappel réservation #' . $reservation->id . ': ' . $e->getMessage());
            }
        }

        $this->info("{$sent} rappel(s) envoyé(s) pour des réservations commençant dans {$minutes} minute(s)." );

        return self::SUCCESS;
    }
}
