<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

#[Layout('layouts.guest')] // We gebruiken weer jouw mooie inlog-layout met het logo
class TwoFactorChallenge extends Component
{
    public $code;
    public $setupMode = false;
    public $tempSecret;
    public $qrCodeSvg;

    public function mount()
    {
        $user = Auth::user();

        // Check of de gebruiker al is ingelogd (veiligheidscheck)
        if (!$user) {
            return redirect()->route('login');
        }

        // Als de gebruiker nog géén 2FA secret in de database heeft, gaan we het instellen!
        if (! $user->two_factor_secret) {
            $this->setupMode = true;

            $google2fa = new Google2FA();
            // Genereer een nieuwe geheime sleutel (maar we slaan hem nog NIET op in de database)
            $this->tempSecret = $google2fa->generateSecretKey();

            // Genereer de unieke URL voor de Authenticator App
            $qrCodeUrl = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $this->tempSecret
            );

            // Teken de QR code als een haarscherpe SVG afbeelding
            $renderer = new ImageRenderer(
                new RendererStyle(250),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $this->qrCodeSvg = $writer->writeString($qrCodeUrl);
        }
    }

    public function verify()
    {
        $this->validate([
            'code' => 'required|numeric|digits:6',
        ], [
            'code.required' => 'Vul de 6-cijferige code in.',
            'code.digits' => 'De code moet exact 6 cijfers lang zijn.'
        ]);

        $user = Auth::user();
        $google2fa = new Google2FA();

        // Welke sleutel moeten we controleren?
        // Bij de eerste setup de tijdelijke sleutel, anders de sleutel uit de database.
        $secretToCheck = $this->setupMode ? $this->tempSecret : $user->two_factor_secret;

        // Controleer of de code uit de app klopt met de secret!
        $valid = $google2fa->verifyKey($secretToCheck, $this->code);

        if ($valid) {
            // Gelukt! Als we in setup-modus waren, is het nu tijd om de sleutel écht op te slaan.
            if ($this->setupMode) {
                $user->update(['two_factor_secret' => $this->tempSecret]);
            }

            // We zetten een stempel in de sessie: Deze gebruiker is veilig langs de 2FA poort gekomen.
            session(['2fa_passed' => true]);

            // Stuur ze eindelijk door naar hun felbegeerde dashboard
            return redirect()->intended(route('dashboard'));
        } else {
            // Foute code
            $this->addError('code', 'De code is onjuist of verlopen. Probeer het opnieuw.');
        }
    }

    public function render()
    {
        return view('livewire.auth.two-factor-challenge');
    }
}
