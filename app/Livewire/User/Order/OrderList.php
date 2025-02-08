<?php

namespace App\Livewire\User\Order;

use App\Models\Order;
use App\Models\Point;
use App\Models\Product;
use Livewire\Component;
use App\Models\Cart as ModelCart;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OrderList extends Component
{
    use LivewireAlert;
    public $userOrders;
    public $activeTab = 'order';

    public function selectTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function mount()
    {
        $this->loadListOrder();
    }
    public function loadListOrder()
    {
        $this->userOrders = Order::where('user_id', auth()->user()->id)->latest()->get();
        if (!$this->userOrders) {
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
    public function confirmOrder($id)
    {
        $order = Order::where('id', $id)->first();
        // Jika pesanan ditemukan
        if ($order && $order->getCart) {
            // ambil dari model
            $totalPoints = $order->calculateTotalPointsIN();
            // Simpan total poin ke tabel points
            Point::create([
                'user_id' => auth()->id(),
                'amount'  => $totalPoints,
                'status'  => 'in', 
                'desc'    => 'poin dari pesanan order_id = ' . $order->id,
            ]);

            // Update status pesanan menjadi finish
            $order->update([
                'status' => 'finish',
            ]);
            $this->loadListOrder();
            $this->alert('success', 'Pesanan dikonfirmasi, Anda mendapatkan ' . $totalPoints . ' poin!');
            return back();
        }
    }
    public function render()
    {
        $productPopulars = Product::where('status', 'active')->where('is_popular','popular')->latest()->take(10)->get();
        return view('livewire.user.order.order-list', compact('productPopulars'));
    }
}
