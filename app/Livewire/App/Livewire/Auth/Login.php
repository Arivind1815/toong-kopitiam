<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $username;
    public $password;

    public function login()
    {
        // Basic login logic here
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}