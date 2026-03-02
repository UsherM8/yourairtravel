<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitation;

class CreateUser extends Component
{
    public $name;
    public $email;
    public $is_admin = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'is_admin' => 'boolean',
    ];

public function createUser()
    {
        $this->validate();

        // Maak de gebruiker aan met een extreem lang, onbruikbaar dummy-wachtwoord
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make(Str::random(40)),
            'is_admin' => $this->is_admin,
        ]);

        // Maak een unieke, getekende link die na 24 uur verloopt
        // We noemen de route nu 'invite.set-password'
        $inviteUrl = URL::temporarySignedRoute(
            'invite.set-password', now()->addDay(), ['user' => $user->id]
        );

        // Stuur de e-mail (we sturen geen tijdelijk wachtwoord meer mee!)
        Mail::to($user->email)->send(new UserInvitation($user, $inviteUrl));

        session()->flash('message', 'Gebruiker aangemaakt! Uitnodiging is verstuurd. ✉️');

        $this->reset(['name', 'email', 'is_admin']);
    }

    public function render()
    {
        return view('livewire.admin.create-user')->layout('layouts.app');
    }
}
