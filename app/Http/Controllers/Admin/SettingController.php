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
        $settings = Setting::all()->pluck('value', 'key');
        
        // Valeurs par défaut
        $defaults = [
            'site_name' => 'Data Center Manager',
            'contact_email' => 'contact@example.com',
            'timezone' => 'Europe/Paris',
            'max_booking_days' => 7,
            'min_booking_notice' => 24, // heures
            'max_concurrent_bookings' => 3,
            'maintenance_mode' => false,
            'maintenance_message' => 'Le système est actuellement en maintenance. Veuillez réessayer plus tard.'
        ];
        
        // Fusionner avec les valeurs par défaut
        $settings = array_merge($defaults, $settings->toArray());
        
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

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Vider le cache des paramètres
        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès');
    }
}
