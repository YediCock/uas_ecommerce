<?php

namespace App\Livewire\Admin\PaymentMethod;

use App\Models\PaymentMethod;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
class PaymentMethodList extends Component
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
        $paymentMethods = PaymentMethod::where('status', '!=', 'deleted')->latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.admin.payment-method.payment-method-list',compact('paymentMethods'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
    public function deletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)->first();

        $paymentMethod->status = "deleted";
        $paymentMethod->save();

        $this->alert('success', 'Berhasil menghapus akun bank ini');
        return back();
    }
}
