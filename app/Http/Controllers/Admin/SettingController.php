<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Afficher le formulaire de configuration
     */
    public function index()
    {
        // Temporarily disabled - table doesn't exist yet
        // $settings = Setting::all()->pluck('value', 'key');
        
        // Valeurs par défaut
        $settings = [
            'site_name' => 'Data Center Management',
            'site_description' => 'Système de gestion du centre de données',
            'admin_email' => 'admin@datacenter.com',
            'timezone' => 'Europe/Paris',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'language' => 'fr',
            'maintenance_mode' => false,
            'max_file_size' => 10240,
            'allowed_extensions' => 'jpg,jpeg,png,pdf,doc,docx',
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Mettre à jour les paramètres
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'timezone' => 'required|timezone',
            'max_booking_days' => 'required|integer|min:1',
            'min_booking_notice' => 'required|integer|min:1',
            'max_concurrent_bookings' => 'required|integer|min:1',
            'maintenance_mode' => 'sometimes|boolean',
            'maintenance_message' => 'nullable|string',
        ]);

        // Temporarily disabled - table doesn't exist yet
        // foreach ($validated as $key => $value) {
        //     Setting::updateOrCreate(
        //         ['key' => $key],
        //         ['value' => $value]
        //     );
        // }

        // Vider le cache des paramètres
        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès (sauvegarde temporairement désactivée)');
    }
}
