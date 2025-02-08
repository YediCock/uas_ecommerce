<?php

namespace App\Livewire\User\Profile;

use App\Models\Cart as ModelCart;
use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PersonalData extends Component
{
    use LivewireAlert;
    public $name;
    public $email;
    public $phone;
    public $user;
    public function getCartCountProperty()
    {
        $user = auth()->user();
        if ($user) {
            return ModelCart::where('user_id', $user->id)->where('status', 'pending')->sum('quantity');
        }
        return 0;
    }
    public function mount()
    {
        $this->user = User::where('id', auth()->user()->id)->first();

        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->phone = $this->user->phone;
        }
    }
    public function render()
    {
        return view('livewire.user.profile.personal-data');
    }
    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'required|numeric',
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        
        if ($user) {

            $user->email = $this->email;
            $user->name = $this->name;
            $user->phone = $this->phone;
            $user->save();

            $this->flash('success', 'Profil berhasil diperbarui.');
        } else {
            $this->flash('error', 'Pengguna tidak ditemukan.');
        }

        return redirect()->to('/profile');
    }
}
