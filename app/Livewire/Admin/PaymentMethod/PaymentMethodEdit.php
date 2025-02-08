<?php

namespace App\Livewire\Admin\PaymentMethod;

use App\Models\PaymentMethod;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;
class PaymentMethodEdit extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $account_name, $account_number, $bank, $status, $image;
    public $paymentMethod;
    public function mount($id)
    {
        $this->paymentMethod = PaymentMethod::where('id',$id)->first();

        if ($this->paymentMethod) {
            $this->name = $this->paymentMethod->name;
            $this->account_name = $this->paymentMethod->account_name;
            $this->account_number = $this->paymentMethod->account_number;
            $this->bank = $this->paymentMethod->bank;
            $this->status = $this->paymentMethod->status;
        }
    }
    public function render()
    {
        return view('livewire.admin.payment-method.payment-method-edit');
    }
    public function editPaymentMethod()
    {
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $this->paymentMethod->id,
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|max:255',
            'bank' => 'required|string|max:255',
            'status' => 'required|in:active,nonactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->image) {
                // Hapus gambar lama jika ada
                if (file_exists(public_path('assets/paymentMethod/' . $this->paymentMethod->image))) {
                    unlink(public_path('assets/paymentMethod/' . $this->paymentMethod->image));
                }

                $random = Str::random(20);
                $img = $this->image;
                $imgBank = $random . '.' . $img->getClientOriginalExtension();
                $location = 'assets/paymentMethod/';
                $path = ($location . $imgBank);
                $upload = Image::make($img->path())->resize(184, 104);
                $upload->save($path);    

                $this->paymentMethod->update(['image' => $imgBank]);
            }

            // Handle store creation
            $this->paymentMethod->update([
                'name' => $this->name,
                'account_name' => $this->account_name,
                'account_number' => $this->account_number,
                'bank' => $this->bank,
                'status' => $this->status,
            ]);
        }

        $this->flash('success', 'Akun bank berhasil diperbarui');
        return redirect()->to('/admin/paymentMethod/list-paymentMethod');
    }
}
