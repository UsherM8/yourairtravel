<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')] // We gebruiken de Breeze inlog-layout (met jouw mooie grote logo!)
class SetPassword extends Component
{
    public User $user;
    public $password;
    public $password_confirmation;

    // Check of de link geldig is als de pagina laadt
    public function mount(Request $request, User $user)
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Deze uitnodigingslink is verlopen of ongeldig. Vraag een nieuwe uitnodiging aan.');
        }

        $this->user = $user;
    }

    public function savePassword()
    {
        // Valideer het nieuwe wachtwoord
        $this->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Sla op
        $this->user->update([
            'password' => Hash::make($this->password),
        ]);

        // Log de gebruiker direct in!
        Auth::login($this->user);

        // Stuur ze naar het dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.set-password');
    }
}
