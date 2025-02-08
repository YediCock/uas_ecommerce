<?php

namespace App\Livewire\User\Wishlist;

use App\Models\Product;
use Livewire\Component;
use App\Models\Cart as ModelCart;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Wishlist extends Component
{
    use LivewireAlert;
    public $userWishlists;
    public $activeTab = 'wishlist';

    public function selectTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function mount()
    {
        $this->loadWishlists();
    }
    public function loadWishlists()
    {
        $this->userWishlists = \App\Models\Wishlist::where('user_id', auth()->user()->id)->latest()->get();
        if (!$this->userWishlists) {
            abort(404);
        } 
    }
    public function getCartCountProperty()
    {
        $user = auth()->user();
        if ($user) {
            return ModelCart::where('user_id', $user->id)->where('status', 'pending')->sum('quantity');
        }
        return 0;
    }
    public function deleteWishlist($productID)
    {
        $wishlist = \App\Models\Wishlist::where('user_id', auth()->user()->id)->where('product_id', $productID)->first();

        if ($wishlist) {
            $wishlist->delete();
        }
        $this->loadWishlists();
        $this->alert('success', 'Berhasil dihapus dari daftar wishlist Anda');
        return back();
    }
    public function render()
    {
        $productPopulars = Product::where('status', 'active')->where('is_popular','popular')->latest()->take(10)->get();
        return view('livewire.user.wishlist.wishlist', compact('productPopulars'));
    }
}
