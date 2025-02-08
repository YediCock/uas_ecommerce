<?php

namespace App\Livewire\User\Product;

use App\Models\Product;
use Livewire\Component;

class PaymentSuccess extends Component
{
    public $activeTab = 'null'; // Default active tab
    public function selectTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function render()
    {
        $products = Product::where('status', 'active')->latest()->take(10)->get();
        return view('livewire.user.product.payment-success', compact('products'));
    }
}
