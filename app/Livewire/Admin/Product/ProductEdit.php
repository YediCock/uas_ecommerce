<?php

namespace App\Livewire\Admin\Product;

use App\Models\Asset;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use App\Models\ProductAttributeValue;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;

class ProductEdit extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $categoryID, $is_popular, $price,$weight, $point, $status, $img_thumbnail, $product_image, $discount;
    public $desc = '';
    public $selectedAttributes = [];
    public $produkAttribute;
    public $product;
    public function mount($id)
    {
        $this->product = Product::where('id',$id)->first();

        if ($this->product) {
            $this->name = $this->product->name;
            $this->categoryID = $this->product->category_id;
            $this->price = $this->product->price;
            $this->weight = $this->product->weight;
            $this->desc = $this->product->desc;
            $this->point = $this->product->point;
            $this->is_popular = $this->product->is_popular;
            $this->status = $this->product->status;
            $this->discount = $this->product->discount;
        }

        // Mengambil atribut produk dan harga tambahan
        foreach ($this->product->getProductAttributeValues as $productAttributeValue) {
            $attributeId = $productAttributeValue->getAttributeValues->attribute_id;
            $valueId = $productAttributeValue->attribute_value_id;
            $price = $productAttributeValue->price;
            $weight = $productAttributeValue->weight;

            $this->selectedAttributes[$attributeId][$valueId] = [
                'checked' => true,
                'price' => $price,
                'weight' => $weight,
            ];
        }
    }
    public function render()
    {
        $dataAttributes = Attribute::with(['getAttributeValues' => function ($query) {
            $query->where('status', 'active');
        }])->where('status', 'active')->get();
        $categories = Category::where('status', 'active')->get();
        return view('livewire.admin.product.product-edit', compact('categories','dataAttributes'));
    }
    public function typeAttribute()
    {
        $this->produkAttribute = 1; 
    }
    // delete image product
    public function deleteImageProduct($idImage)
    {
        $imageProduct = Asset::where('product_id', $this->product->id)->where('id',$idImage)->where('type', 'product')->first();
        if ($imageProduct) {
            // Hapus gambar 
            $image = public_path('/assets/assetImage/' . $imageProduct->image);
            if (File::exists($image)) {
                File::delete($image);
            }

            // Hapus entri dari tabel asset
            $imageProduct->delete();
        }
        $this->alert('success', 'Berhasil menghapus gambar produk ini');
        return back();
    }
    public function editProduct()
    {
        // dd($this->selectedAttributes);
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $this->product->id,
            'categoryID' => 'required|exists:categories,id',
            'is_popular' => 'required|in:popular,notpopular',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'point' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'status' => 'required|in:active,nonactive',
            'desc' => 'required',
            'img_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'product_image' => 'nullable|array|max:5',
            'product_image.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'selectedAttributes' => 'nullable|array',
            'selectedAttributes.*' => 'array',
        ]);        

        if ($validatedData) {
            // Handle update thumbnail image
            if ($this->img_thumbnail) {
                // Hapus gambar lama jika ada
                if (file_exists(public_path('assets/product/' . $this->product->img_thumbnail))) {
                    unlink(public_path('assets/product/' . $this->product->img_thumbnail));
                }

                $random = Str::random(20);
                $imgThumbnail = $this->img_thumbnail;
                $thumbnailProduct = $random . '.' . $imgThumbnail->getClientOriginalExtension();
                $location = 'assets/product/';
                $path = ($location . $thumbnailProduct);
                $upload = Image::make($imgThumbnail->path())->resize(660, 760);
                $upload->save($path);

                // Update thumbnail image
                $this->product->update(['img_thumbnail' => $thumbnailProduct]);
            }

            // Handle update diskon
            if ($this->discount !== 0 && $this->discount !== '') {
                // Jika ada nilai di input discount, update nilainya
                $this->product->update(['discount' => $this->discount]);
            } else {
                // Jika input discount dikosongkan, set nilainya ke 0
                $this->product->update(['discount' => 0]);
            }

            // Update product details
            $this->product->update([
                'name' => $this->name,
                'category_id' => $this->categoryID,
                'is_popular' => $this->is_popular,
                'price' => $this->price,
                'weight' => $this->weight,
                'point' => $this->point,
                'status' => $this->status,
                'desc' => $this->desc,
            ]);

            // Handle multiple store images
            if ($this->product_image) {
                $validateHomeImage =  $this->validate([
                    'product_image' => 'array|min:1|max:5',
                    'product_image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
                if ($validateHomeImage) {
                    $totalImages = $this->product->getAsset()->count(); // Menghitung jumlah gambar yang sudah ada
                    $maxImages = 5 - $totalImages; // Maksimal gambar yang bisa ditambahkan

                    // Periksa apakah jumlah gambar yang akan ditambahkan melebihi batas maksimum
                    if (count($this->product_image) > $maxImages) {
                        $this->alert('warning', 'Total gambar properti melebihi 5 file'); // back
                        return back();
                    } else {
                        foreach ($this->product_image as $key => $image) {
                            // Cek apakah jumlah gambar yang akan disimpan telah mencapai batas maksimum
                            if ($key < $maxImages) {
                                $random = Str::random(20);
                                $imageProduct = $random . '.' . $image->getClientOriginalExtension();
                                $location = 'assets/assetImage/';
                                $path = ($location . $imageProduct);
                                $upload = Image::make($image->path())->resize(660, 760);
                                $upload->save($path);
                
                                Asset::create([
                                    'product_id' => $this->product->id,
                                    'image' => $imageProduct,
                                    'type' => 'product',
                                ]);
                            }else {
                                // Jika jumlah gambar sudah mencapai batas maksimum, hentikan iterasi
                                break;
                            }
                        }
                    }
                }
            }

            // Menyimpan atribut produk jika ada
            if (!empty($this->selectedAttributes)) {
                $existingAttributes = $this->product->getProductAttributeValues->keyBy('attribute_value_id');
                $hasCheckedAttributes = false; // Flag untuk memeriksa apakah ada atribut yang dicentang

                foreach ($this->selectedAttributes as $attributeId => $values) {
                    foreach ($values as $valueId => $attributeData) {
                        if (!empty($attributeData['checked'])) {
                            // Periksa apakah kunci 'price' ada di $attributeData, jika tidak setel menjadi 0
                            $price = isset($attributeData['price']) && is_numeric($attributeData['price']) ? $attributeData['price'] : 0;
                            $weight = isset($attributeData['weight']) && is_numeric($attributeData['weight']) ? $attributeData['weight'] : 0;

                            // Perbarui atau buat nilai atribut
                            ProductAttributeValue::updateOrCreate(
                                ['product_id' => $this->product->id, 'attribute_value_id' => $valueId],
                                ['price' => $price, 'weight' => $weight] 
                            );

                            $hasCheckedAttributes = true; // Set flag jika ada yang dicentang
                        } else {
                            // Hapus nilai atribut jika tidak dicentang
                            if (isset($existingAttributes[$valueId])) {
                                $existingAttributes[$valueId]->delete();
                            }
                        }
                    }
                }
                if ($hasCheckedAttributes) {
                    // Jika ada atribut yang dicentang, pastikan tipe produk tetap 'attribute'
                    $this->product->update(['type' => 'attribute']);
                } else {
                    // Jika tidak ada atribut yang dicentang, ubah tipe produk menjadi 'simple'
                    $this->product->update(['type' => 'simple']);
                    $this->product->getProductAttributeValues()->delete();
                }
            } else {
                // Jika tidak ada atribut yang dipilih, ubah tipe produk menjadi 'simple'
                if ($this->product->type == 'attribute') {
                    $this->product->update(['type' => 'simple']);
                    $this->product->getProductAttributeValues()->delete();
                }
            }

        }
        $this->flash('success', 'Produk berhasil diperbarui');
        return redirect()->to('/admin/product/list-product');
    }
}
