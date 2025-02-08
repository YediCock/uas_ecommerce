<?php

namespace App\Livewire\User\Profile;

use App\Models\Cart as ModelCart;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UpdatePassword extends Component
{
    use LivewireAlert;
    public $passwordOld;
    public $passwordNew;
    public $confirm_password;

    // Rules untuk validasi
    protected $rules = [
        'passwordOld' => 'required',
        'passwordNew' => 'required|min:8',
        'confirm_password' => 'required|same:passwordNew',
    ];
    public function getCartCountProperty()
    {
        $user = auth()->user();
        if ($user) {
            return ModelCart::where('user_id', $user->id)->where('status', 'pending')->sum('quantity');
        }
        return 0;
    }
    // Fungsi untuk memperbarui password
    public function updatePassword()
    {
        $this->validate(); // Validasi input

        // Cek apakah password lama cocok dengan yang ada di database
        if (!Hash::check($this->passwordOld, Auth::user()->password)) {
            $this->addError('passwordOld', 'Password lama salah.');
            return;
        }
        $user = User::where('id', auth()->user()->id)->first();
        $user->password = Hash::make($this->passwordNew);
        $user->save();

        $this->flash('success', 'Password berhasil diperbarui.');
        return redirect()->to('/profile');
    }

    public function render()
    {
        return view('livewire.user.profile.update-password');
    }
}
