<?php

namespace App\Livewire\User\Order;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\Cart as ModelCart;

class OrderDetail extends Component
{
    public $activeTab = 'order';
    public $userOrder;
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
    public function mount($orderID)
    {
        $this->userOrder = Order::where('id', $orderID)->first();
        if (!$this->userOrder) {
            abort(404);
        } 
    }
    public function render()
    {
        $productPopulars = Product::where('status', 'active')->where('is_popular','popular')->latest()->take(10)->get();
        return view('livewire.user.order.order-detail', compact('productPopulars'));
    }
}
