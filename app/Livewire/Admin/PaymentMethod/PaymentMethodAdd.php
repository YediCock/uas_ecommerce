<?php

namespace App\Livewire\Admin\PaymentMethod;

use App\Models\PaymentMethod as ModelPaymentMethod;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;
class PaymentMethodAdd extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $account_name, $account_number, $bank, $status, $image;

    public function render()
    {
        return view('livewire.admin.payment-method.payment-method-add');
    }
    public function addPaymentMethod()
    {
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:payment_methods',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|max:255',
            'bank' => 'required|string|max:255',
            'status' => 'required|in:active,nonactive',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->image) {
                $random = Str::random(20);
                $img = $this->image;
                $imgBank = $random . '.' . $img->getClientOriginalExtension();
                $location = 'assets/paymentMethod/';
                $path = ($location . $imgBank);
                $upload = Image::make($img->path())->resize(184, 104);
                $upload->save($path);    
            }

            // Handle store creation
            ModelPaymentMethod::create([
                'name' => $this->name,
                'account_name' => $this->account_name,
                'account_number' => $this->account_number,
                'bank' => $this->bank,
                'status' => $this->status,
                'image' => $imgBank,
            ]);
        }

        $this->flash('success', 'Akun bank berhasil ditambahkan');
        return redirect()->to('/admin/paymentMethod/list-paymentMethod');
    }
}
