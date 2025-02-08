<?php
namespace App\Livewire\User\Product;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Cart as ModelCart;
use App\Models\ProductAttributeValue;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailProduct extends Component
{
    use LivewireAlert;
    public $name,$price,$desc,$discount;
    public $product;
    public $selectedAttributes = [];
    public $finalPrice;
    public $action;
    public $quantity = 1;
    public function increaseQuantity()
    {
        $this->quantity++;
    }
    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    public function mount($id)
    {
        $this->product = Product::where('id', $id)->where('status', 'active')->first();
        if ($this->product) {
            $this->name = $this->product->name;
            $this->price = $this->product->price;
            $this->finalPrice = $this->price;
            $this->desc = $this->product->desc;
            $this->discount = $this->product->discount;
        }

        foreach ($this->product->getProductAttributeValues as $productAttributeValue) {
            $attributeId = $productAttributeValue->getAttributeValues->attribute_id;
            $valueId = $productAttributeValue->attribute_value_id;
            $price = $productAttributeValue->price;

            $this->selectedAttributes[$attributeId][$valueId] = [
                'checked' => false, // Inisialisasi dengan false
                'price' => $price,
            ];
        }
    }
    public function selectAttributeValue($attributeId, $valueId, $price)
    {
        // Reset semua nilai untuk atribut yang dipilih
        foreach ($this->selectedAttributes[$attributeId] as &$value) {
            $value['checked'] = false;
        }

        // Tandai nilai yang dipilih sebagai aktif
        $this->selectedAttributes[$attributeId][$valueId]['checked'] = true;

        // Perbarui harga akhir
        $this->updateFinalPrice();
    }
    protected function updateFinalPrice()
    {
        // Set harga dasar dari produk
        $this->finalPrice = $this->price;

        // Tambahkan harga atribut yang dipilih (jika ada)
        foreach ($this->selectedAttributes as $attributeValues) {
            foreach ($attributeValues as $value) {
                if ($value['checked']) {
                    $this->finalPrice += $value['price'];
                }
            }
        }
    }
    // actian tambah keranjang atau beli sekarang
    public function setAction($action)
    {
        $this->action = $action;
    }
    // Buat metode terpisah untuk validasi dan mengumpulkan atribut
    private function validateAndCollectAttributes()
    {
        // Validasi: Memastikan semua atribut dipilih
        foreach ($this->selectedAttributes as $attributeId => $values) {
            $isSelected = false;
            foreach ($values as $value) {
                if ($value['checked']) {
                    $isSelected = true;
                    break;
                }
            }
            if (!$isSelected) {
                $this->alert('error', 'Semua atribut harus dipilih sebelum melanjutkan.');
                return null; // Return null untuk indikasi error
            }
        }

        // Mengumpulkan atribut yang dipilih
        $attributes = [];
        foreach ($this->selectedAttributes as $attributeId => $values) {
            foreach ($values as $valueId => $value) {
                if ($value['checked']) {
                    $productAttributeValue = ProductAttributeValue::where('attribute_value_id', $valueId)
                        ->where('product_id', $this->product->id)
                        ->first();

                    $attributeName = $productAttributeValue->getAttributeValues->takeAttributes->name ?? '';
                    $valueName = $productAttributeValue->getAttributeValues->name ?? '';

                    $attributes[] = [
                        'attribute_name' => $attributeName,
                        'attribute_value' => $valueName,
                        'additional_price' => $productAttributeValue->price,
                        'additional_weight' => $productAttributeValue->weight,
                    ];
                }
            }
        }

        return $attributes; // Return attributes jika sukses
    }

// Fungsi addToCart yang memanggil metode validateAndCollectAttributes
    public function addToCart()
    {
        $user = auth()->user();

        if (!$user) {
            // Simpan URL saat ini di session sebelum redirect
            session(['redirect_to_detailProduct' => "/detail-product/{$this->product->id}"]);
            return redirect()->to('/login');
        }

        // Panggil metode validateAndCollectAttributes
        $attributes = $this->validateAndCollectAttributes();
        
        if (is_null($attributes)) {
            return back(); // Berhenti jika validasi gagal
        }

        // Encode attributes to JSON
        $attributesJson = json_encode($attributes);

        // Cari apakah sudah ada produk dengan product_id dan atribut yang sama
        $existingCart = ModelCart::where('user_id', $user->id)
            ->where('product_id', $this->product->id)
            ->where('status', 'pending')
            ->where('attributes', $attributesJson)
            ->first();

        if ($existingCart) {
            // Jika sudah ada, update kuantitasnya
            $existingCart->quantity += $this->quantity;
            $existingCart->save();
        } else {
            // Jika belum ada, tambahkan produk baru ke keranjang
            ModelCart::create([
                'user_id' => $user->id,
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
                'status' => 'pending',
                'attributes' => $attributesJson,
            ]);
        }
        $this->alert('success', 'Produk berhasil ditambahkan ke keranjang.');
        return back();
    }
    // Fungsi buyNow yang memanggil metode validateAndCollectAttributes
    public function buyNow()
    {
        $user = auth()->user();

        if (!$user) {
            // Simpan URL saat ini di session sebelum redirect
            session(['redirect_to_detailProduct' => "/detail-product/{$this->product->id}"]);
            return redirect()->to('/login');
        }

        // Panggil metode validateAndCollectAttributes
        $attributes = $this->validateAndCollectAttributes();
        
        if (is_null($attributes)) {
            return back(); // Berhenti jika validasi gagal
        }

        // Encode attributes to JSON
        $attributesJson = json_encode($attributes);

        // Hapus semua sesi keranjang belanja
        session()->forget('cart');

        // Simpan informasi produk ke dalam sesi
        session()->put('cart', [
            'product_id' => $this->product->id,
            'user_id' => $user->id,
            'quantity' => $this->quantity,
            'attributes' => $attributesJson,
        ]);
        // Arahkan ke halaman checkout
        return redirect()->route('checkoutProduct', ['userID' => auth()->user()->id]);
    }
    // untuk menghitung jumlah item di keranjang
    public function getCartCountProperty()
    {
        $user = auth()->user();
        if ($user) {
            return ModelCart::where('user_id', $user->id)->where('status', 'pending')->sum('quantity');
        }
        return 0;
    }
    // add wishlist
    public function addWishlist()
    {
        if ($this->product) {
            // Periksa apakah user sudah wishlist product ini sebelumnya
            $wishlistExists = Wishlist::where('product_id', $this->product->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->exists();

            if ($wishlistExists) {
                // Jika user sudah wishlist product ini sebelumnya, tampilkan pesan error
                $this->alert('error', 'Sudah ada di daftar wishlist Anda');
                return back();
            }else{
                Wishlist::create([
                    'product_id' => $this->product->id,
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
        return view('livewire.user.product.detail-product');
    }    
}
