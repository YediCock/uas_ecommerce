<?php

namespace App\Livewire\User\Product;

use App\Models\Order;
use App\Models\Point;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Cart as ModelsCart;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Checkout extends Component
{
    use LivewireAlert;

    public $carts, $name, $address, $phone;
    public $provinces = [];
    public $cities = [];
    public $selectedProvince = null;
    public $selectedCity = null;
    public $couriers = ['jne', 'pos', 'tiki'];
    public $shippingOptions = [];
    public $selectedShipping = null;
    // variabel rincian pembayaran
    public $shippingCost = 0;
    public $subtotal = 0;
    public $taxAmount = 0;
    public $totalAmount = 0;
    public $totalWeight = 0;
    public $totalPoints = 0;
    public $usePoints = false; 
    public function mount($userID)
    {
        // Ambil produk dari session
        $cartSession = session('cart');
    
        // Jika ada data di session, tampilkan di checkout
        if ($cartSession) {
            // Ubah session menjadi koleksi model
            $this->carts = ModelsCart::hydrate([$cartSession]);
        } else {
            // Jika tidak ada produk di session, ambil dari database
            $this->carts = ModelsCart::where('user_id', $userID)
                                    ->where('status', 'pending')
                                    ->latest()
                                    ->get();
        }
    
        // Hitung total poin user
        $this->totalPoints = Point::getTotalPoints(auth()->user()->id);
        $this->fetchProvinces();
        $this->shippingOptions = [];
        $this->calculateTotals();
    }
    
// ======= rincian pembayaran =======
    public function updatedSelectedShipping($value)
    {
        // Periksa jika carts kosong dan reload dari session jika perlu
        if (session()->has('cart')) {
            $cartSession = session('cart');
            $this->carts = ModelsCart::hydrate([$cartSession]);
        }
        $this->calculateShippingCost();
        $this->calculateTotals();
    }
    public function updated()
    {
        // Periksa jika carts kosong dan reload dari session jika perlu
        if (session()->has('cart')) {
            $cartSession = session('cart');
            $this->carts = ModelsCart::hydrate([$cartSession]);
        }
        $this->calculateTotals();
    }
    public function calculateSubtotal()
    {
        $this->subtotal = $this->carts->reduce(function ($carry, $cart) {
            return $carry + $cart->calculateTotalPrice($cart->getProduct->price, $cart->attributes) * $cart->quantity;
        }, 0);
    }
    public function calculateShippingCost()
    {
        if ($this->selectedShipping && $this->shippingOptions) {
            // Pecah value berdasarkan delimiter "|"
            $selectedParts = explode('|', $this->selectedShipping);
            
            if (count($selectedParts) === 2) {
                $selectedCourier = trim($selectedParts[0]);
                $selectedService = trim($selectedParts[1]);
                
                // Cari shipping option yang sesuai
                $shippingOption = collect($this->shippingOptions)
                    ->first(function ($option) use ($selectedCourier, $selectedService) {
                        return $option['courier'] === $selectedCourier && $option['service'] === $selectedService;
                    });

                // Set nilai shippingCost jika ditemukan
                if ($shippingOption) {
                    $this->shippingCost = $shippingOption['cost'][0]['value'];
                } else {
                    $this->shippingCost = 0;
                }
            } else {
                // Reset shippingCost jika parsing gagal
                $this->shippingCost = 0;
            }
        } else {
            // Reset shippingCost jika selectedShipping kosong atau shippingOptions kosong
            $this->shippingCost = 0;
        }
    }
    public function calculateTotals()
    {
        $this->calculateSubtotal();
        $this->calculateShippingCost();
        
        $ppnPercentage = Setting::first()->value;
        $this->taxAmount = ($this->subtotal * $ppnPercentage) / 100;
        
        // Hitung total setelah penggunaan poin
        if ($this->usePoints == true && $this->totalPoints > 0) {
            $this->totalAmount = $this->subtotal + $this->shippingCost + $this->taxAmount - $this->totalPoints;
        } else {
            $this->totalAmount = $this->subtotal + $this->shippingCost + $this->taxAmount;
        }
    }

// ======= Rajaongkir =======
    public function updatedSelectedProvince()
    {
        $this->selectedCity = null; // Reset selected city when province changes
        $this->cities = []; // Clear cities
        $this->shippingOptions = []; // Clear shipping options
        $this->shippingCost = 0;
        // Periksa jika carts kosong dan reload dari session jika perlu
        if (session()->has('cart')) {
            $cartSession = session('cart');
            $this->carts = ModelsCart::hydrate([$cartSession]);
        }

        if ($this->selectedProvince) {
            $this->fetchCities();
        }
    }
    public function updatedSelectedCity($value)
    {
        $this->selectedCity = $value;
        $this->selectedShipping = null;
        $this->shippingOptions = []; // Clear shipping options
        $this->shippingCost = 0;
        // Periksa jika carts kosong dan reload dari session jika perlu
        if (session()->has('cart')) {
            $cartSession = session('cart');
            $this->carts = ModelsCart::hydrate([$cartSession]);
        }

        if ($this->selectedCity) {
            $this->fetchShippingOptions();
        }
    }
    // ambil data provinsi
    public function fetchProvinces()
    {
        $response = Http::withoutVerifying()->withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get(env('RAJAONGKIR_BASE_URL') . 'province');

        $body = $response->json();

        if ($response->status() === 200 && $body['rajaongkir']['status']['code'] === 200) {
            $this->provinces = $body['rajaongkir']['results'];
        } else {
            $this->alert('error', 'Provinces data could not be loaded. Please try again later.');
        }
    }
    // ambil data kota
    public function fetchCities()
    {
        if ($this->selectedProvince) {
            $response = Http::withoutVerifying()->withHeaders([
                'key' => env('RAJAONGKIR_API_KEY'),
            ])->get(env('RAJAONGKIR_BASE_URL') . 'city', [
                'province' => $this->selectedProvince,
            ]);

            $body = $response->json();

            if ($response->status() === 200 && $body['rajaongkir']['status']['code'] === 200) {
                $this->cities = $body['rajaongkir']['results'];
            } else {
                $this->alert('error', 'Cities data could not be loaded. Please try again later.');
            }
        }
    }
    // menghitung ongkos kirim
    public function fetchShippingOptions()
    {
        // Pastikan selectedCity sudah terisi
        if ($this->selectedCity) {
            // Reset shipping options sebelum memulai pemanggilan API
            $this->shippingOptions = [];
            
            // Hitung total berat barang di keranjang
            $this->totalWeight = 0; // Reset totalWeight

            foreach ($this->carts as $cart) {
                // Ambil berat awal produk
                $initialWeight = $cart->getProduct->weight; 

                // Periksa apakah atribut ada dan merupakan array
                $attributes = $cart->attributes; // Menggunakan accessor dari model
                
                if (is_array($attributes)) {
                    foreach ($attributes as $attribute) {
                        // Tambahkan berat jika ada atribut tambahan berat
                        if (isset($attribute['additional_weight']) && is_numeric($attribute['additional_weight'])) {
                            $initialWeight += $attribute['additional_weight'];
                        }
                    }
                }
                // Kalikan berat total per produk dengan kuantitas di keranjang
                $this->totalWeight += $initialWeight * $cart->quantity;
            }

            // dd($this->totalWeight); 

            // Loop melalui setiap kurir untuk mendapatkan opsi pengiriman
            foreach ($this->couriers as $courier) {
                $response = Http::withoutVerifying()->withHeaders([
                    'key' => env('RAJAONGKIR_API_KEY'),
                ])->post(env('RAJAONGKIR_BASE_URL') . 'cost', [
                    'origin' => env('RAJAONGKIR_ORIGIN'),
                    'destination' => $this->selectedCity,
                    'weight' => $this->totalWeight, 
                    'courier' => $courier,
                ]);

                $body = $response->json();

                // Cek apakah respons sukses
                if ($response->status() === 200 && $body['rajaongkir']['status']['code'] === 200) {
                    // Gabungkan hasil dari setiap kurir ke dalam shippingOptions
                    foreach ($body['rajaongkir']['results'] as $result) {
                        foreach ($result['costs'] as $cost) {
                            // Menambahkan informasi kurir ke setiap opsi
                            $cost['courier'] = strtoupper($result['code']);
                            $this->shippingOptions[] = $cost;
                        }
                    }
                } else {
                    $this->alert('error', 'Shipping options could not be loaded for ' . strtoupper($courier) . '. Please try again later.');
                }
            }
        }
    }    
// ========= checkout ==============
    public function checkout()
    {
        // Periksa jika carts kosong dan reload dari session jika perlu
        if (session()->has('cart')) {
            $cartSession = session('cart');
            $this->carts = ModelsCart::hydrate([$cartSession]);
        }
        $this->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'selectedProvince' => 'required',
            'selectedCity' => 'required',
            'selectedShipping' => 'required',
        ]);
        // ambil nama ongkir dan layanannya
        $selectedParts = explode('|', $this->selectedShipping);
        $selectedCourier = trim($selectedParts[0]);
        $selectedService = trim($selectedParts[1]);
        // Ambil nama provinsi berdasarkan selectedProvince
        $province = collect($this->provinces)->firstWhere('province_id', $this->selectedProvince);
        $provinceName = $province ? $province['province'] : null;
        // Ambil nama kota berdasarkan selectedCity
        $city = collect($this->cities)->firstWhere('city_id', $this->selectedCity);
        $cityName = $city ? $city['type'] . ' ' . $city['city_name'] : null;
        // Simpan order ke database
        $order = Order::create([
            'customer_name' => $this->name,
            'user_id' => auth()->id(),
            'address' => $this->address,
            'phone' => $this->phone,
            'total_price' => $this->subtotal,
            'tax_amount' => $this->taxAmount,
            'tax' => Setting::first()->value,
            'point_out' => $this->usePoints ? $this->totalPoints : 0, 
            'final_price' => $this->totalAmount,
            'total_weight' => $this->totalWeight, 
            'shipping_cost' => $this->shippingCost,
            'customer_city_id' => $this->selectedCity,
            'customer_province_id' => $this->selectedProvince,
            'customer_city' => $cityName,
            'customer_province' => $provinceName,
            'shipping_courier' => $selectedCourier,
            'shipping_service_name' => $selectedService,
        ]);
        // Simpan penggunaan poin di tabel Point jika ada
        if ($this->usePoints == true && $this->totalPoints > 0) {
            Point::create([
                'user_id' => auth()->id(),
                'amount' => $this->totalPoints,
                'status' => 'out',
                'desc' => 'Poin digunakan untuk order_id = ' . $order->id,
            ]);
        }
        // jika ada session
        if (session()->has('cart')) {
            $cartSession = session('cart');
            // Simpan data produk dari session ke tabel carts dengan order_id
            if (is_array($cartSession)) {
                // Periksa apakah attributes adalah string JSON yang sudah di-encode
                $attributes = is_string($cartSession['attributes']) ? $cartSession['attributes'] : json_encode($cartSession['attributes'], JSON_UNESCAPED_UNICODE);
                ModelsCart::create([
                    'product_id' => $cartSession['product_id'],
                    'user_id' => auth()->id(),
                    'quantity' => $cartSession['quantity'],
                    'attributes' => $attributes,
                    'order_id' => $order->id,
                    'status' => 'success'
                ]);
            }
            // Hapus session cart setelah checkout
            session()->forget('cart');
        } else {
            // Update status dan order_id di tabel carts
            ModelsCart::where('user_id', auth()->id())
                ->where('status', 'pending') 
                ->update([
                    'order_id' => $order->id,
                    'status' => 'success'
                ]);
        }
    
        return redirect()->route('paymentProduct', ['orderID' => $order->id]);
    }
    public function render()
    {
        return view('livewire.user.product.checkout', [
            'provinces' => $this->provinces,
            'cities' => $this->cities,
            'shippingOptions' => $this->shippingOptions,
            'settings' => Setting::get(),
        ]);
    }
}
