<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SitePasswordProtection
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Het geheime wachtwoord (verander dit naar wat je wilt!)
        $secret = 'yat2026';

        // 2. Als de gebruiker het wachtwoord invult via de gate
        if ($request->has('site_password')) {
            if ($request->site_password === $secret) {
                session(['site_access_granted' => true]);
               return redirect()->to($request->path());
            }
            return back()->with('error', 'Onjuist wachtwoord.');
        }

        // 3. Check of de gebruiker al toegang heeft of op de inlogpagina probeert te komen
        if (!session('site_access_granted')) {
            return response(view('errors.site-gate'));
        }

        return $next($request);
    }
}
