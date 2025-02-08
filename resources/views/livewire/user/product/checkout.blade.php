<div>
    <!-- header Section start -->
    <header class="header-style-6 header-absolute search-header d-flex align-items-center header-style-5">
        <!-- Arrow Back Icon with Border -->
        <a href="/cart-product/{{ auth()->user()->id }}" class="rounded-circle fw-bold title-color" style="border: 1px solid #d3d3d3; padding: 6px;">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        
        <!-- Search Input with Icon -->
        <div class="left-header header-title w-100">
            <h4 class="m-auto">Checkout</h4>
        </div>
        <div class="header-right">
            <a href="notification.html" class="notification">
                <i class="ri-notification-2-line"></i>
            </a>
        </div>
    </header>
    {{-- header Section end --}}
    <!-- shipping address Start -->
    <section class="section-t-sm-space cart-section">
        <div class="custom-container">
            <div class="title-2 mb-3">
                <h4>Alamat Pengiriman</h4>
            </div>
            <div class="acount-form-box">
                <form class="form-style-9">
                    <div class="form-box mb-3">
                        <label for="fname" class="form-label fw-semibold">Nama Penerima</label>
                        <input wire:model="name" type="text" class="form-control" id="fname">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-box mb-3">
                        <label for="lname" class="form-label fw-semibold">Nomer Telepon</label>
                        <input wire:model="phone" type="number" class="form-control" id="lname">
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!-- Pilihan Provinsi -->
                    <div class="form-box mb-3">
                        <label for="" class="form-label fw-semibold">Provinsi</label>
                        <select wire:model="selectedProvince" wire:change="fetchCities" class="form-select form-control" aria-label="Default select example">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                            @endforeach
                        </select>
                        @error('selectedProvince') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!-- Pilihan Kota/Kabupaten -->
                    <div class="form-box mb-3">
                        <label for="lname" class="form-label fw-semibold">Kota / Kabupaten</label>
                        <select wire:model="selectedCity" wire:change="fetchShippingOptions" class="form-select form-control" aria-label="Default select example">
                            <option value="">Pilih Kota / Kabupaten</option>
                            @foreach($cities as $city)
                                <option value="{{ $city['city_id'] }}">{{ ($city['type'] === 'Kota' ? 'Kota' : 'Kabupaten') . ' ' . $city['city_name'] }}</option>
                            @endforeach
                        </select>
                        @error('selectedCity') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-box mb-3">
                        <label for="bio" class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea wire:model="address" class="form-control" id="bio" rows="3"></textarea>
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- shipping address End -->
    <!-- Cart Section Start -->
    <section class="section-t-sm-space cart-section">
        <div class="custom-container">
            <div class="title-2 mb-1">
                <h4>Pesanan Kamu</h4>
            </div>
            <div class="cart-items-list">
                <ul class="items-list px-0">
                    @foreach($carts as $cart)
                        <li style="padding: 10px 0px;">
                            <div class="cart-box position-relative">
                                <div class="items-image">
                                    <img src="/assets/product/{{ $cart->getProduct->img_thumbnail }}" class="img-fluid" alt="">
                                </div>
                                <div class="items-name">
                                    <div>
                                        <a href="{{ route('detailProductUser', $cart->getProduct->id) }}">
                                            <h5>{{ $cart->getProduct->name }}</h5>
                                        </a>
                                        <div class="">
                                            <div class="d-flex align-items-center">
                                                <!-- Menampilkan harga tanpa diskon -->
                                                <h6 class="fw-bold me-2 mb-0">
                                                    Rp.{{ number_format($cart->calculateTotalPrice($cart->getProduct->price, $cart->attributes), 0, ',', '.') }}
                                                </h6>
                                            </div>
                                        </div>
                                        <!-- Tampilkan atribut produk -->
                                        @if($cart->attributes)
                                            <h6>
                                                @foreach($cart->attributes as $attribute)
                                                    {{ $attribute['attribute_name'] }}: {{ $attribute['attribute_value'] }}.
                                                @endforeach
                                            </h6>
                                        @endif
                                    </div>
                                    <div class="quantity-box justify-content-between">
                                        <div class=""></div>
                                        <h6 class="fw-bold">x {{ $cart->quantity }}</h6>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach             
                </ul>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->
    <!-- select ongkir Start -->
    <section class="section-t-sm-space cart-section">
        <div class="custom-container">
            <div class="title-2 mb-3">
                <h4>Pilih Jasa Pengiriman</h4>
            </div>
            <div class="acount-form-box">
                <form class="form-style-9">
                    <!-- Pilihan Kurir dan Ongkos Kirim -->
                    <div class="form-box mb-3">
                        <label for="lname" class="form-label fw-semibold">Kurir dan Paket Pengiriman</label>
                        <select wire:model="selectedShipping" wire:change="calculateShippingCost" class="form-select form-control" aria-label="Default select example">
                            <option value="">Pilih Kurir dan Paket Pengiriman</option>
                            @foreach($shippingOptions as $option)
                                <option value="{{ $option['courier'] . '|' . $option['service'] }}">
                                    {{ $option['courier'] }} | {{ $option['service'] }} | {{ $option['cost'][0]['etd'] }} Hari | Rp. {{ number_format($option['cost'][0]['value'], 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('selectedShipping') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- select ongkir End -->
    <!-- Banner Section Start -->
    <section class="section-t-sm-space pb-3">
        <div class="custom-container">
            <div class="title-2 mb-3">
                <h4>Rincian Pembayaran</h4>
            </div>
            <div class="order-detail-box mt-0 pt-0">
                <ul class="order-price-list">
                    <li>
                        <div class="order-price-box">
                            <h4 class="name">Subtotal ({{ $carts->sum('quantity') }} produk)</h4>
                            <h4 class="price">Rp{{ number_format($this->subtotal, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                    @if($totalPoints > 0)
                    <li class="privacy-setting-section">
                        <form class="privacy-setting-form">
                            <div class="form-check form-switch order-price-box">
                                <h4 class="name">Tukarkan Point Belanja</h4>
                                <div class="d-flex">
                                    <h4 class="price me-2" style="color: #FFA000">-Rp{{ number_format($totalPoints, 0, ',', '.') }}</h4>
                                    <input wire:model.live="usePoints" class="form-check-input" type="checkbox" style="border: 1px solid #FFA000;">
                                </div>
                            </div>
                        </form>
                    </li>
                    @endif
                    <li>
                        <div class="order-price-box">
                            <h4 class="name">Total Biaya Pengiriman</h4>
                            <h4 class="price">Rp{{ number_format($this->shippingCost, 0, ',', '.') }}</h4>
                        </div>
                    </li>

                    <li>
                        <div class="order-price-box">
                            <h4 class="name">PPN {{ $settings[0]->value }}%</h4>
                            <h4 class="price">Rp{{ number_format($this->taxAmount, 0, ',', '.') }}</h4>
                        </div>
                    </li>

                    <li class="total-price">
                        <div class="order-price-box">
                            <h4 class="name">Total Pembayaran</h4>
                            <h4 class="price">Rp{{ number_format($this->totalAmount, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->
    <!-- Process To Next Step Start -->
    <div class="next-step" style="border-top: 1px solid #d3d3d3">
        <div class="left-box">
            <h6>Total Pembayaran</h6>
            <h4 class="text-dark">Rp{{ number_format($this->totalAmount, 0, ',', '.') }}</h4>
        </div>
        <div class="right-box d-flex align-items-center">
            <a class="me-3" wire:loading>Loading..</a>
            <a class="btn theme-bg-color text-white" wire:click="checkout">Buat Pesanan</a>
        </div>
    </div>
    <!-- Process To Next Step End -->
</div>
