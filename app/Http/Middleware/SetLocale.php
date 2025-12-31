<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Check route parameter first (for /lang/{locale} routes)
        $locale = $request->route('locale')
            ?? $request->get('lang')
            ?? session('locale', 'ar');

        if (in_array($locale, ['ar', 'en', 'fr', 'es'])) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}
