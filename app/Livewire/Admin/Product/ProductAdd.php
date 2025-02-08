<?php

namespace App\Livewire\Admin\Product;

use App\Models\Asset;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\ProductAttributeValue;
use App\Models\Attribute;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;

class ProductAdd extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $categoryID, $is_popular, $price,$weight, $point, $discount, $status, $img_thumbnail, $product_image;
    public $desc = '';
    public $selectedAttributes = [];
    public $produkAttribute;
    public function render()
    {
        $dataAttributes = Attribute::with(['getAttributeValues' => function ($query) {
            $query->where('status', 'active');
        }])->where('status', 'active')->get();

        $categories = Category::where('status', 'active')->get();
        
        return view('livewire.admin.product.product-add', compact('categories','dataAttributes'));
    }
    public function addProduct()
    {
        // dd($this->selectedAttributes);
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:products',
            'categoryID' => 'required|exists:categories,id',
            'is_popular' => 'required|in:popular,notpopular',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'point' => 'required|numeric',
            'status' => 'required|in:active,nonactive',
            'desc' => 'required',
            'discount' => 'nullable|numeric',
            'img_thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'product_image' => 'required|array|min:1|max:5',
            'product_image.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'selectedAttributes' => 'nullable|array',
            'selectedAttributes.*' => 'array',
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->img_thumbnail) {
                $random = Str::random(20);
                $imgThumbnail = $this->img_thumbnail;
                $thumbnailProduct = $random . '.' . $imgThumbnail->getClientOriginalExtension();
                $location = 'assets/product/';
                $path = ($location . $thumbnailProduct);
                $upload = Image::make($imgThumbnail->path())->resize(660, 760);
                $upload->save($path);    
            }
            // Menetapkan default nilai discount jika tidak diisi
            $this->discount = $this->discount ?? 0;
            // Handle store creation
            $product = Product::create([
                'name' => $this->name,
                'category_id' => $this->categoryID,
                'is_popular' => $this->is_popular,
                'price' => $this->price,
                'weight' => $this->weight,
                'point' => $this->point,
                'status' => $this->status,
                'desc' => $this->desc,
                'discount' => $this->discount,
                'img_thumbnail' => $thumbnailProduct,
            ]);

            // Handle multiple store images
            if ($this->product_image) {
                foreach ($this->product_image as $image) {
                    $random = Str::random(20);
                    $imageProduct = $random . '.' . $image->getClientOriginalExtension();
                    $location = 'assets/assetImage/';
                    $path = ($location . $imageProduct);
                    $upload = Image::make($image->path())->resize(660, 760);
                    $upload->save($path);

                    Asset::create([
                        'product_id' => $product->id,
                        'image' => $imageProduct,
                        'type' => 'product',
                    ]);
                }
            }

            // Menyimpan atribut produk jika ada
            if (!empty($this->selectedAttributes)) {
                // Update type produk
                $product->update(['type' => 'attribute']);

                foreach ($this->selectedAttributes as $attributeId => $values) {
                    foreach ($values as $valueId => $valueData) {
                        if (isset($valueData['checked']) && $valueData['checked']) {
                            ProductAttributeValue::create([
                                'product_id' => $product->id,
                                'attribute_value_id' => $valueId,
                                'price' => $valueData['price'] ?? 0, // Simpan harga tambahan
                                'weight' => $valueData['weight'] ?? 0, // Simpan berat tambahan
                            ]);
                        }
                    }
                }
            }
        }

        $this->flash('success', 'Produk berhasil ditambahkan');
        return redirect()->to('/admin/product/list-product');
    }
    public function typeAttribute()
    {
        $this->produkAttribute = 1; 
    }
} 