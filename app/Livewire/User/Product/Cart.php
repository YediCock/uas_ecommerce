<?php

namespace App\Livewire\User\Product;

use App\Models\Product;
use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Cart as ModelsCart;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Cart extends Component
{
    use LivewireAlert;
    public $carts;
    public $totalPriceAllProduct = 0;
    public $totalQuantity = 0;
    public function mount($userID)
    {
        $this->carts = ModelsCart::where('user_id', $userID)->where('status', 'pending')->latest()->get();
        $this->calculateTotals();
    }
    // menghapus produk di cart
    public function deleteCart($id)
    {
        $cart = ModelsCart::where('id', $id)->where('status', 'pending')->first();

        // Hapus entri dari tabel cart
        $cart->delete();
        // Refresh data keranjang
        $this->carts = ModelsCart::where('user_id', auth()->user()->id)->where('status', 'pending')->latest()->get();
        $this->calculateTotals();
        $this->alert('success', 'Berhasil menghapus produk ini');
        return back();
    }
    // menghitung total harga dan total quantity
    public function calculateTotals()
    {
        $this->totalPriceAllProduct = $this->carts->sum(function ($cart) {
            // Ambil harga dasar dan atribut dari cart
            $basePrice = $cart->getProduct->price;
            $attributes = $cart->attributes;
    
            // Panggil metode calculateTotalPrice
            return $cart->calculateTotalPrice($basePrice, $attributes) * $cart->quantity;
        });
        
        $this->totalQuantity = $this->carts->sum('quantity');
    }
    public function updateQuantity($cartId, $quantity)
    {
        $cart = ModelsCart::where('id', $cartId)->first();
        $cart->quantity = $quantity;
        $cart->save();
        // Refresh data keranjang sebelum menghitung total
        $this->carts = ModelsCart::where('user_id', auth()->user()->id)->where('status', 'pending')->latest()->get();
        // Update totals setelah memperbarui keranjang
        $this->calculateTotals();
    }
    public function checkoutProduct()
    {
        // Hapus session cart
        session()->forget('cart');

        // Lanjutkan ke logika checkout, misalnya arahkan ke halaman pembayaran
        return redirect()->route('checkoutProduct', ['userID' => auth()->user()->id]);
    }
    // add wishlist
    public function addWishlist($productID)
    {
        $product = Product::where('id', $productID)->where('status', 'active')->first();
        if ($product) {
            // Periksa apakah user sudah wishlist product ini sebelumnya
            $wishlistExists = Wishlist::where('product_id', $product->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->exists();

            if ($wishlistExists) {
                // Jika user sudah wishlist product ini sebelumnya, tampilkan pesan error
                $this->alert('error', 'Sudah ada di daftar wishlist Anda');
                return back();
            }else{
                Wishlist::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id,
                ]);
                $this->alert('success', 'Berhasil dimasukan kedalam daftar wishlist Anda');
                return back();
            }
        }else {
            // Penanganan jika $cekUser null (tidak ada data yang ditemukan)
            $this->alert('error', 'Pengguna tidak ditemukan.');
            return back();
        }
    }
    public function render()
    {
        $productPopulars = Product::where('status', 'active')->where('is_popular','popular')->latest()->take(10)->get();
        return view('livewire.user.product.cart', compact('productPopulars'));
    }
}
