<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check of de gebruiker is ingelogd én het admin vinkje heeft
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Zo niet? Gooi ze naar een 403 (Verboden Toegang) pagina
        abort(403, 'Geen toegang. Dit is alleen voor de beheerder.');
    }
}
