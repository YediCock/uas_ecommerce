<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Login extends Component
{
    use LivewireAlert;
    public $email;
    public $password;
    public $redirectUrl;
    public function mount()
    {
        // Ambil URL redirect dari query parameter
        $this->redirectUrl =  session('redirect_to_detailProduct', '/profile');
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
    public function loginCurrentUser()
    {
        $this->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
    
        // Periksa apakah inputnya berupa email atau nomor telepon
        $loginType = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    
        $credentials = [
            $loginType => $this->email,
            'password' => $this->password,
        ];
    
        // Attempt to login
        if (auth()->attempt($credentials)) {
            session()->regenerate();
            $role = auth()->user()->role;
    
            if ($role == 'admin') {
                return redirect('/admin/dashboard');
            } else {
                $redirectUrl = $this->redirectUrl;
                session()->forget('redirect_to_detailProduct'); // Hapus session redirect
                return redirect()->to($redirectUrl);
            }
        }
    
        // If login fails
        $this->alert('error', 'Akun tidak ditemukan atau password salah');
        return back();
    }
    
}
