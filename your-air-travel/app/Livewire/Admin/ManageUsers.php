<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageUsers extends Component
{
    public $userToDelete = null;
    public $adminPassword = '';
    public $showDeleteModal = false;

    // --- NIEUW: Rechten switchen ---
    public function toggleAdminRole($userId)
    {
        $user = User::findOrFail($userId);

        // Voorkom dat je jezelf per ongeluk degradeert
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Je kunt je eigen rechten niet aanpassen.');
            return;
        }

        // Switch de boolean (true wordt false, false wordt true)
        $user->update([
            'is_admin' => !$user->is_admin
        ]);

        $nieuweRol = $user->is_admin ? 'Admin' : 'Medewerker';
        session()->flash('message', "Rechten van {$user->name} succesvol aangepast naar {$nieuweRol}.");
    }

    // --- VERWIJDER LOGICA ---
    public function confirmDelete($userId)
    {
        $this->userToDelete = $userId;
        $this->adminPassword = '';
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        $this->validate([
            'adminPassword' => 'required',
        ], [
            'adminPassword.required' => 'Je moet je wachtwoord invullen om dit te bevestigen.'
        ]);

        if (! Hash::check($this->adminPassword, auth()->user()->password)) {
            $this->addError('adminPassword', 'Wachtwoord is onjuist. Actie geannuleerd.');
            return;
        }

        if ($this->userToDelete === auth()->id()) {
            $this->addError('adminPassword', 'Je kunt je eigen account niet verwijderen.');
            return;
        }

        User::findOrFail($this->userToDelete)->delete();

        $this->showDeleteModal = false;
        $this->userToDelete = null;
        $this->adminPassword = '';

        session()->flash('message', 'Gebruiker is definitief en veilig verwijderd.');
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
        $this->adminPassword = '';
    }

    public function render()
    {
        $users = User::latest()->get();
        return view('livewire.admin.manage-users', compact('users'));
    }
}
