<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name;
    public $phone;
    public $email;
    public $password;
    public $confirm_password;
    public $redirectUrl;
    public function mount()
    {
        // Ambil URL redirect dari session, jika ada
        $this->redirectUrl = session('redirect_to_detailProduct', '/profile');
    }
    public function registerCurrentUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        // Login the user after successful registration
        auth()->login($user);

        session()->regenerate();

        $redirectUrl = $this->redirectUrl;
        session()->forget('redirect_to_detailProduct'); // Hapus session redirect
        return redirect()->to($redirectUrl);
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
