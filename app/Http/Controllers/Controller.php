<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Validation stricte avec protection XSS
     */
    protected function validateStrict(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        // Nettoyer automatiquement les inputs contre XSS
        $this->sanitizeInputs($request);

        // Validation stricte
        return $this->validate($request, $rules, $messages, $customAttributes);
    }

    /**
     * Nettoyer les inputs contre les attaques XSS
     */
    protected function sanitizeInputs(Request $request)
    {
        $allInputs = $request->all();
        
        foreach ($allInputs as $key => $value) {
            if (is_string($value)) {
                // Nettoyage XSS
                $cleaned = $this->cleanXSS($value);
                $request->merge([$key => $cleaned]);
            } elseif (is_array($value)) {
                // Nettoyage récursif pour les tableaux
                $request->merge([$key => $this->cleanArrayXSS($value)]);
            }
        }
    }

    /**
     * Nettoyer une chaîne contre XSS
     */
    protected function cleanXSS($string)
    {
        // Suppression des tags HTML/JavaScript dangereux
        $string = strip_tags($string);
        
        // Encodage des caractères spéciaux
        $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        
        // Suppression des caractères de contrôle
        $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $string);
        
        // Nettoyage des tentatives d'injection JavaScript
        $string = preg_replace('/javascript:/i', '', $string);
        $string = preg_replace('/vbscript:/i', '', $string);
        $string = preg_replace('/onload=/i', '', $string);
        $string = preg_replace('/onerror=/i', '', $string);
        $string = preg_replace('/onclick=/i', '', $string);
        $string = preg_replace('/onmouseover=/i', '', $string);
        
        return $string;
    }

    /**
     * Nettoyer un tableau contre XSS (récursif)
     */
    protected function cleanArrayXSS(array $array)
    {
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $array[$key] = $this->cleanXSS($value);
            } elseif (is_array($value)) {
                $array[$key] = $this->cleanArrayXSS($value);
            }
        }
        
        return $array;
    }

    /**
     * Valider les emails avec vérification stricte
     */
    protected function validateEmailStrict($email)
    {
        // Vérification basique
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Vérification du domaine (optionnel)
        $domain = substr(strrchr($email, "@"), 1);
        if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
            return false;
        }

        return true;
    }

    /**
     * Valider les mots de passe avec des critères stricts
     */
    protected function validatePasswordStrict($password)
    {
        // Minimum 8 caractères
        if (strlen($password) < 8) {
            return false;
        }

        // Au moins une lettre majuscule
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // Au moins une lettre minuscule
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // Au moins un chiffre
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        // Au moins un caractère spécial
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            return false;
        }

        return true;
    }

    /**
     * Protection contre les tentatives de force brute
     */
    protected function checkRateLimit(Request $request, $maxAttempts = 5, $decayMinutes = 1)
    {
        $key = 'rate_limit:' . $request->ip() . ':' . $request->route()->getName();
        
        if (cache()->get($key) >= $maxAttempts) {
            throw ValidationException::withMessages([
                'rate_limit' => 'Trop de tentatives. Veuillez réessayer dans ' . $decayMinutes . ' minute(s).'
            ]);
        }

        cache()->increment($key, $decayMinutes * 60);
    }

    /**
     * Logger les tentatives suspectes
     */
    protected function logSuspiciousActivity(Request $request, $activity)
    {
        $logData = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'activity' => $activity,
            'timestamp' => now(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ];

        if (auth()->check()) {
            $logData['user_id'] = auth()->id();
            $logData['user_email'] = auth()->user()->email;
        }

        \Log::warning('Suspicious activity detected', $logData);
    }

    /**
     * Validation des numéros de téléphone
     */
    protected function validatePhoneNumber($phone)
    {
        // Nettoyer le numéro
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Vérifier le format international
        if (preg_match('/^\+[1-9]\d{1,14}$/', $phone)) {
            return $phone;
        }
        
        return false;
    }

    /**
     * Validation des URLs
     */
    protected function validateUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // Vérifier que l'URL utilise HTTP/HTTPS
        $parsed = parse_url($url);
        return in_array($parsed['scheme'] ?? '', ['http', 'https']);
    }
}
