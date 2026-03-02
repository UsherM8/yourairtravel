<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check of de gebruiker überhaupt is ingelogd
        if (auth()->check()) {

            // 2. Check of ze het 2FA-stempel in hun sessie hebben ('2fa_passed')
            if (! session('2fa_passed', false)) {

                // 3. Voorkom een "oneindige loop": Als ze al op de 2FA pagina zijn, laat ze dan met rust!
                if (! $request->routeIs('2fa.challenge')) {
                    return redirect()->route('2fa.challenge');
                }
            }
        }

        return $next($request);
    }
}
