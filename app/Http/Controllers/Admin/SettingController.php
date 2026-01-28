<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index()
    {
        $settings = [
            'app_name' => config('app.name', 'Data Center Management'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'app_timezone' => config('app.timezone'),
            'database_connection' => config('database.default'),
            'mail_driver' => config('mail.default'),
            'queue_connection' => config('queue.default'),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }
    
    /**
     * Update the system settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_timezone' => 'required|string|timezone',
        ]);
        
        // Note: En production, ces paramètres seraient sauvegardés en base de données
        // Pour la démo, on retourne juste un message de succès
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès!');
    }
}
