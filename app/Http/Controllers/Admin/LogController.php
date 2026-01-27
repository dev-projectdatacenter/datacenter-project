<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /**
     * Affiche la liste des fichiers de logs
     */
    public function index(Request $request)
    {
        $logFiles = [];
        $logPath = storage_path('logs');
        
        if (File::exists($logPath)) {
            $logFiles = array_diff(scandir($logPath), ['..', '.', '.gitignore']);
            $logFiles = array_values($logFiles); // Réindexer le tableau
        }

        $actions = [
            'login' => 'Connexion',
            'logout' => 'Déconnexion',
            'create' => 'Création',
            'update' => 'Mise à jour',
            'delete' => 'Suppression',
            'error' => 'Erreur',
            'warning' => 'Avertissement'
        ];

        // Récupérer les logs avec les relations
        $logs = \App\Models\ActivityLog::with('user')
            ->when($request->action, function($query, $action) {
                return $query->where('action', $action);
            })
            ->when($request->user_id, function($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->when($request->date, function($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.logs.index', compact('logFiles', 'actions', 'logs'));
    }

    /**
     * Affiche le contenu d'un fichier de log spécifique
     */
    public function show($filename)
    {
        $filePath = storage_path('logs/' . $filename);
        
        if (!File::exists($filePath)) {
            abort(404, 'Fichier de log non trouvé');
        }

        $content = File::get($filePath);
        
        return view('admin.logs.show', [
            'filename' => $filename,
            'content' => $content
        ]);
    }

    /**
     * Exporte les logs au format CSV
     */
    public function export()
    {
        $logsPath = storage_path('logs');
        $logFiles = File::files($logsPath);
        
        $csvData = [];
        
        foreach ($logFiles as $file) {
            if ($file->getExtension() === 'log') {
                $csvData[] = [
                    'file_name' => $file->getFilename(),
                    'size' => $file->getSize(),
                    'last_modified' => date('Y-m-d H:i:s', $file->getMTime())
                ];
            }
        }
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="logs_export_' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, ['Nom du fichier', 'Taille (octets)', 'Dernière modification']);
            
            // Données
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Affiche les statistiques des logs
     */
    public function statistics()
    {
        $logsPath = storage_path('logs');
        $logFiles = File::files($logsPath);
        
        $stats = [
            'total_files' => 0,
            'total_size' => 0,
            'files' => []
        ];
        
        foreach ($logFiles as $file) {
            if ($file->getExtension() === 'log') {
                $stats['total_files']++;
                $stats['total_size'] += $file->getSize();
                $stats['files'][] = [
                    'name' => $file->getFilename(),
                    'size' => $file->getSize(),
                    'last_modified' => date('Y-m-d H:i:s', $file->getMTime())
                ];
            }
        }
        
        return view('admin.logs.statistics', [
            'stats' => $stats
        ]);
    }

    /**
     * Supprime les logs plus anciens qu'un certain nombre de jours
     */
    public function clear(Request $request)
    {
        $days = $request->input('days', 30);
        $cutoffDate = now()->subDays($days);
        
        $deleted = \App\Models\ActivityLog::where('created_at', '<', $cutoffDate)->delete();
        
        return redirect()
            ->route('admin.logs.index')
            ->with('success', "$deleted logs plus anciens que $days jours ont été supprimés avec succès.");
    }
}
