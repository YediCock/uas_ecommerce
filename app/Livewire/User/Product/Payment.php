<?php

namespace App\Livewire\User\Product;

use App\Models\Cart as ModelsCart;
use App\Models\Order;
use App\Models\PaymentMethod;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManagerStatic as Image;
class Payment extends Component
{
    use WithFileUploads;

    public $carts, $order, $paymentMethods, $confirm_payment;
    public function mount($orderID)
    {
        $this->carts = ModelsCart::where('user_id', auth()->user()->id)->where('order_id', $orderID)->latest()->get();
        $this->order = Order::where('id', $orderID)->first();
        $this->paymentMethods = PaymentMethod::get();
    }
    public function render()
    {
        return view('livewire.user.product.payment');
    }
    public function confirm()
    {
        $this->validate([
            'confirm_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $random = Str::random(20);
        $img = $this->confirm_payment;
        $imgBank = $random . '.' . $img->getClientOriginalExtension();
        $location = 'assets/confirmPayment/';
        $path = ($location . $imgBank);
        $upload = Image::make($img->path());
        $upload->save($path);    

        $this->order->update(['proof_of_payment' => $imgBank]);

        $this->order->update([
            'status' => 'unpaid',
        ]);
    
        return redirect()->to('/order/finished');
    }
}
