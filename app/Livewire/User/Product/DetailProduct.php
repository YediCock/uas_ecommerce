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
    public $cartCount;

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

        $this->cartCount = $this->getCartCountProperty();
    }
    public function selectAttributeValue($attributeId, $valueId, $price)
    {
        foreach ($this->selectedAttributes[$attributeId] as &$value) {
            $value['checked'] = false;
        }
        $this->selectedAttributes[$attributeId][$valueId]['checked'] = true;
        $this->updateFinalPrice();
    }
    protected function updateFinalPrice()
    {
        $this->finalPrice = $this->price;
        foreach ($this->selectedAttributes as $attributeValues) {
            foreach ($attributeValues as $value) {
                if ($value['checked']) {
                    $this->finalPrice += $value['price'];
                }
            }
        }
    }
    public function setAction($action)
    {
        $this->action = $action;
    }
    private function validateAndCollectAttributes()
    {
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
                return null;
            }
        }

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

        return $attributes;
    }
    public function addToCart()
    {
        $user = auth()->user();
        if (!$user) {
            session(['redirect_to_detailProduct' => "/detail-product/{$this->product->id}"]);
            return redirect()->to('/login');
        }
        $attributes = $this->validateAndCollectAttributes();
        if (is_null($attributes)) {
            return back();
        }
        $attributesJson = json_encode($attributes);
        $existingCart = ModelCart::where('user_id', $user->id)
            ->where('product_id', $this->product->id)
            ->where('status', 'pending')
            ->where('attributes', $attributesJson)
            ->first();
        if ($existingCart) {
            $existingCart->quantity += $this->quantity;
            $existingCart->save();
        } else {
            ModelCart::create([
                'user_id' => $user->id,
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
                'status' => 'pending',
                'attributes' => $attributesJson,
            ]);
        }
        $this->cartCount = $this->getCartCountProperty();
        $this->alert('success', 'Produk berhasil ditambahkan ke keranjang.');
        return back();
    }
    public function getCartCountProperty()
    {
        $user = auth()->user();
        if ($user) {
            return ModelCart::where('user_id', $user->id)->where('status', 'pending')->sum('quantity');
        }
        return 0;
    }
    public function addWishlist()
    {
        if ($this->product) {
            $wishlistExists = Wishlist::where('product_id', $this->product->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->exists();
            if ($wishlistExists) {
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
            $this->alert('error', 'Pengguna tidak ditemukan.');
            return back();
        }
    }
    public function render()
    {
        return view('livewire.user.product.detail-product');
    }    
}
