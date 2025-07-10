<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLogin extends Component
{
    public $username;
    public $password;
    public $error;

    public function login()
    {
        $admin = Admin::where('username', $this->username)->first();

        if ($admin && Hash::check($this->password, $admin->password)) {
            session(['admin_id' => $admin->id]);
            return redirect('/admin/dashboard');
        }

        $this->error = 'Invalid username or password.';
    }

    public function render()
    {
        return view('livewire.admin-login');
    }
}

