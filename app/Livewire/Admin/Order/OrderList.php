<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class OrderList extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $limitData;
    public $search = '';
    public function mount()
    {
        $this->limitData = 10;
    }
    public function render()
    {
        $orders = Order::where('status', '!=', 'deleted')->latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.admin.order.order-list', compact('orders'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
}
