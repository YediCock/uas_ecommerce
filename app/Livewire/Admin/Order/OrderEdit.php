<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class OrderEdit extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $order, $track_number;
    public function mount($id)
    {
        $this->loadDetailOrder($id);
    }
    public function loadDetailOrder($id)
    {
        $this->order = Order::where('id',$id)->first();
        if ($this->order) {
            $this->track_number = $this->order->track_number;
        }else {
            abort(404);
        }
    }
    public function render()
    {
        return view('livewire.admin.order.order-edit');
    }
    public function confirmPayment($id)
    {
        $order = Order::where('id', $id)->first();

        $order->status = "paid";
        $order->save();
        $this->loadDetailOrder($id);
        $this->alert('success', 'Berhasil konfirmasi bukti pembayaran ini');
        return back();
    }
    public function editOrder()
    {
        // Validasi input
        $validatedData = $this->validate([
            'track_number' => 'required|string',
        ]);        

        if ($validatedData) {
            // Update order
            $this->order->update([
                'track_number' => $this->track_number,
                'status' => 'shipping',
            ]);
        }
        $this->flash('success', 'Order berhasil diperbarui');
        return redirect()->to('/admin/order/list-order');
    }
}
