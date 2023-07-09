<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Register extends Component
{
    public $form = [
        'name'                  => '',
        'email'                 => '',
        'password'              => '',
        'password_confirmation' => '',
    ];

    public function submit()
    {
        $this->validate([
            'form.email'    => 'required|email',
            'form.name'     => 'required',
            'form.password' => 'required|confirmed',
        ]);
        // The hashing of my password is handled inside my User model by the casts mutator where I set the password value to hashed.
        User::create($this->form);
        return redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.register');
    }
}
