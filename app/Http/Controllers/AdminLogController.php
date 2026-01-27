<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    /**
     * Afficher les logs d'activité
     */
    public function index(Request $request)
    {
        $query = ActivityLogService::getRecentLogs(200);

        // Filtrer par action si spécifié
        if ($request->filled('action')) {
            $query = $query->where('action', $request->action);
        }

        // Filtrer par utilisateur si spécifié
        if ($request->filled('user_id')) {
            $query = $query->where('user_id', $request->user_id);
        }

        // Filtrer par date si spécifié
        if ($request->filled('date')) {
            $query = $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(50);

        // Actions disponibles pour le filtre
        $actions = [
            'login' => 'Connexions',
            'logout' => 'Déconnexions',
            'failed_login' => 'Connexions échouées',
            'user_created' => 'Créations utilisateurs',
            'user_updated' => 'Modifications utilisateurs',
            'user_deleted' => 'Suppressions utilisateurs',
            'account_request_approved' => 'Demandes approuvées',
            'account_request_rejected' => 'Demandes refusées',
        ];

        return view('admin.logs.index', compact('logs', 'actions'));
    }

    /**
     * Afficher les logs de sécurité
     */
    public function security(Request $request)
    {
        $securityActions = ['failed_login', 'user_deleted', 'account_request_rejected'];
        
        $logs = ActivityLogService::getRecentLogs(200)
            ->whereIn('action', $securityActions)
            ->when($request->filled('action'), function ($query) use ($request) {
                return $query->where('action', $request->action);
            })
            ->paginate(50);

        $actions = [
            'failed_login' => 'Tentatives de connexion échouées',
            'user_deleted' => 'Suppressions d\'utilisateurs',
            'account_request_rejected' => 'Demandes de compte refusées',
        ];

        return view('admin.logs.security', compact('logs', 'actions'));
    }

    /**
     * Afficher les logs d'un utilisateur spécifique
     */
    public function userLogs($userId)
    {
        $logs = ActivityLogService::getUserLogs($userId);
        
        return view('admin.logs.user', compact('logs', 'userId'));
    }

    /**
     * Exporter les logs
     */
    public function export(Request $request)
    {
        $logs = ActivityLogService::getRecentLogs(1000);

        // Appliquer les filtres
        if ($request->filled('action')) {
            $logs = $logs->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $logs = $logs->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $logs = $logs->where('created_at', '<=', $request->date_to);
        }

        // Générer le CSV
        $filename = 'logs-activity-' . date('Y-m-d-H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            
            // En-tête CSV
            fputcsv($file, [
                'Date',
                'Utilisateur',
                'Email',
                'Action',
                'Description',
                'Adresse IP',
                'User Agent'
            ]);

            // Données
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user?->name ?? 'N/A',
                    $log->user?->email ?? 'N/A',
                    $log->action,
                    $log->description,
                    $log->ip_address,
                    $log->user_agent,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
