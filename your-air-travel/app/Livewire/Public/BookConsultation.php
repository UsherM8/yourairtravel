<?php

namespace App\Livewire\Public;

use Livewire\Component;

class BookConsultation extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $preferred_date = '';
    public $destination_wishes = '';

    public $isSubmitted = false;

    public function submitRequest()
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'preferred_date' => 'required',
            'destination_wishes' => 'required|min:10',
        ]);

        $this->isSubmitted = true;
    }

    public function render()
    {
        return view('livewire.public.book-consultation')->layout('layouts.public');
    }
}
