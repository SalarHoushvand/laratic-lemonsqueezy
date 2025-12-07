<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie('locale') // First priority: cookie
               ?? session('locale')      // Then: session
               ?? config('app.locale');  // Fallback: app default

        // Validate locale format (e.g., 'en', 'es', 'en-US', 'pt-BR')
        if (! is_string($locale) || ! preg_match('/^[a-z]{2}(-[A-Z]{2})?$/', $locale)) {
            $locale = config('app.locale');
        }

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
