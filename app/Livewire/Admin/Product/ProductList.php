<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductList extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $limitData;
    public $search = '';
    public $selectedProduct;

    public function mount()
    {
        $this->limitData = 10;
    }
    public function render()
    {
        $products = Product::where('status', '!=', 'deleted')->latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.admin.product.product-list', compact('products'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
    // show detail product
    public function showDetailProduct($productID)
    {
        $this->selectedProduct = Product::where('id', $productID)->first();
    }
    public function deleteProduct($id)
    {
        $product = Product::where('id', $id)->first();

        $product->status = "deleted";
        $product->save();

        $this->alert('success', 'Berhasil menghapus produk ini');
        return back();
    }
}
