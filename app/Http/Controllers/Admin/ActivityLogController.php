<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Afficher la liste des logs d'activité
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Filtrer par action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filtrer par utilisateur
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtrer par date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(50);

        // Actions disponibles pour le filtre
        $actions = [
            'login' => 'Connexion',
            'logout' => 'Déconnexion',
            'failed_login' => 'Connexion échouée',
            'user_created' => 'Création utilisateur',
            'user_updated' => 'Modification utilisateur',
            'user_deleted' => 'Suppression utilisateur',
            'account_request_approved' => 'Approbation demande',
            'account_request_rejected' => 'Refus demande',
        ];

        return view('admin.logs.index', compact('logs', 'actions'));
    }

    /**
     * Afficher les détails d'un log
     */
    public function show(ActivityLog $log)
    {
        $log->load('user');
        return view('admin.logs.show', compact('log'));
    }

    /**
     * Exporter les logs en CSV
     */
    public function export(Request $request)
    {
        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Appliquer les mêmes filtres que index()
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->get();

        $filename = 'activity_logs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // En-tête CSV
            fputcsv($file, [
                'Date',
                'Action',
                'Utilisateur',
                'Description',
                'Adresse IP',
                'User Agent'
            ]);
            
            // Données
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('d/m/Y H:i:s'),
                    $log->action,
                    $log->user ? $log->user->name : 'N/A',
                    $log->description,
                    $log->ip_address,
                    $log->user_agent
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Vider les anciens logs
     */
    public function clear(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $deletedCount = ActivityLog::where('created_at', '<', now()->subDays($request->days))
            ->delete();

        return back()->with('success', "{$deletedCount} anciens logs ont été supprimés.");
    }

    /**
     * Statistiques des logs
     */
    public function statistics()
    {
        $stats = [
            'total_logs' => ActivityLog::count(),
            'today_logs' => ActivityLog::whereDate('created_at', today())->count(),
            'failed_logins' => ActivityLog::where('action', 'failed_login')->count(),
            'unique_users' => ActivityLog::distinct('user_id')->whereNotNull('user_id')->count(),
        ];

        // Logs par action pour les graphiques
        $logsByAction = ActivityLog::selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->orderBy('count', 'desc')
            ->get();

        // Logs des 7 derniers jours
        $logsLast7Days = ActivityLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.logs.statistics', compact('stats', 'logsByAction', 'logsLast7Days'));
    }
}
