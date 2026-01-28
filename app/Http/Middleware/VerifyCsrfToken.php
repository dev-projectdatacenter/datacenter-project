<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/login',
        '/logout',
        '/register',
        '/password/*',
    ];
}

    /**
     * Handle unauthenticated access to CSRF protected routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    protected function tokensMatch($request)
    {
        // Vérification stricte du token
        $token = $this->getTokenFromRequest($request);
        
        // Si pas de token dans la requête POST/PUT/DELETE/PATCH
        if (!$token && in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            throw new TokenMismatchException('CSRF token missing');
        }

        return parent::tokensMatch($request);
    }

    /**
     * Add custom headers for enhanced CSRF protection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        // Ajouter des headers de sécurité supplémentaires
        $response = parent::handle($request, $next);
        
        if ($response) {
            // Protection contre le clickjacking
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            
            // Protection contre le MIME-sniffing
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            
            // Politique de référence stricte
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            
            // Protection XSS
            $response->headers->set('X-XSS-Protection', '1; mode=block');
        }

        return $response;
    }

    /**
     * Get the CSRF token from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function getTokenFromRequest($request)
    {
        // Vérifier d'abord dans les headers (pour les requêtes AJAX)
        $token = $request->header('X-CSRF-TOKEN');
        
        if ($token) {
            return $token;
        }

        // Vérifier dans les headers X-XSRF-TOKEN (pour Angular/Vue)
        $token = $request->header('X-XSRF-TOKEN');
        
        if ($token) {
            return $token;
        }

        // Vérifier dans le payload de la requête
        return $request->input('_token') ?: $request->input('csrf_token');
    }
}
