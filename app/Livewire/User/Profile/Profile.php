<?php

namespace App\Livewire\User\Profile;

use App\Models\Cart as ModelCart;
use Livewire\Component;

class Profile extends Component
{
    public $activeTab = 'profile';

    public function selectTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function getCartCountProperty()
    {
        $user = auth()->user();
        if ($user) {
            return ModelCart::where('user_id', $user->id)->where('status', 'pending')->sum('quantity');
        }
        return 0;
    }
    public function render()
    {
        return view('livewire.user.profile.profile');
    }
}
