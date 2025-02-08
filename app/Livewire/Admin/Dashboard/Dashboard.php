<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    #[Layout('components.layouts.admin')]
    public function render()
    {
        $product_count = Product::count();
        $order_finished = Order::where('status', 'finished')->count();
        $order = Order::count();
        return view('livewire.admin.dashboard.dashboard', compact('product_count', 'order_finished', 'order'));
    }
}
