<div>
    <!-- header Section start -->
    <header class="header-style-6 header-absolute search-header d-flex align-items-center header-style-5">
        <!-- Search Input with Icon -->
        <div class="left-header header-title w-100">
            <h4 class="m-auto">Pembayaran</h4>
        </div>
    </header>
    {{-- header Section end --}}
    <!-- Address List Section Start -->
    <section class="section-t-sm-space address-section">
        <div class="custom-container">
            <div class="address-list-box">
                <ul class="address-list">
                    <li style="border: 1px solid #d3d3d3; border-radius: 5px;">
                        <div class="address-box">
                            <div class="address-header pb-0 mb-0">
                                <div class="address-icon">
                                    <i style="color: #FFA000" class="ri-map-pin-line"></i>
                                </div>

                                <div class="address-name">
                                    <h5>Alamat Pengiriman</h5>
                                    <p class="text-black my-2 lh-sm">{{ $order->address }}</p>
                                    <p><span class="text-black">{{ $order->customer_name }}</span> - {{ $order->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Address List Section End -->
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
                            <h4 class="price">Rp.{{ number_format($order->total_price, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                    @if($order->point_out > 0)
                    <li>
                        <div class="order-price-box">
                            <h4 class="name">Penukaran Point Belanja</h4>
                            <h4 class="price" style="color: #FFA000">-Rp.{{ number_format($order->point_out, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                    @endif

                    <li>
                        <div class="order-price-box">
                            <h4 class="name">Total Biaya Pengiriman</h4>
                            <h4 class="price">Rp.{{ number_format($order->shipping_cost, 0, ',', '.') }}</h4>
                        </div>
                    </li>

                    <li>
                        <div class="order-price-box">
                            <h4 class="name">PPN {{ $order->tax }}%</h4>
                            <h4 class="price">Rp.{{ number_format($order->tax_amount, 0, ',', '.') }}</h4>
                        </div>
                    </li>

                    <li class="total-price">
                        <div class="order-price-box">
                            <h4 class="name">Total yang harus dibayar</h4>
                            <h4 class="price">Rp.{{ number_format($order->final_price, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->
    <section class="section-t-sm-space payment-section">
        <div class="custom-container">
            <div class="title-2 mb-2">
                <h4>Transfer pembayaran</h4>
            </div>
            <h5>Silahkan transfer dengan nominal <span style="color: #FFA000">Rp.{{ number_format($order->final_price, 0, ',', '.') }}</span>  ke salah satu rekening berikut</h5>

            <div class="payment-setting-list">
                <ul style="gap: 10px" class="payment-list px-0 rounded-0" style="border-bottom: 1px solid #d3d3d3;">
                    @foreach($paymentMethods as $paymentMethod)
                    <li>
                        <a class="payment-box">
                            <div class="payment-image bg-transparent p-0">
                                <img src="/assets/paymentMethod/{{ $paymentMethod->image }}" class="img-fluid" alt="">
                            </div>
                            <div class="payment-name">
                                <div>
                                    <h5>{{ $paymentMethod->account_name }}</h5>
                                    <h6>{{ $paymentMethod->account_number }}</h6>
                                </div>
                                
                            </div>
                        </a>
                    </li>
                    @endforeach  
                </ul>
            </div>
            <div class="acount-form-box mt-3">
                <form class="form-style-9">
                    <div class="form-box mb-3">
                        <label for="formFile" class="form-label fw-semibold">Upload bukti transfer</label>
                        <input wire:model="confirm_payment" class="rounded form-control" type="file" id="formFile">
                        @error('confirm_payment') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <ul class="guest-detail-box list-unstyled">
                <li class="d-flex align-items-center mb-2">
                    <div class="d-flex justify-content-center align-items-center text-success rounded-circle mx-2" style="width: 40px; height: 40px;">
                        <i class="fs-3 ri-shield-check-fill"></i>
                    </div>
                    <h5 class="m-0">Kami melindungi data privasi anda dengan baik bantuan SkincareStore</h5>
                </li>
            </ul>            
        </div>
    </section>
    <!-- Process To Next Step Start -->
    <div class="next-step" style="border-top: 1px solid #d3d3d3">
        <div class="left-box">
            {{-- <h6>Total Pembayaran</h6> --}}
            <h4 class="text-dark">Apakah Anda sudah benar membayar?</h4>
        </div>
        <div class="right-box">
            <a class="btn theme-bg-color text-white btn-sm d-md-none d-block" wire:click="confirm">Konfirmasi Sekarang</a>
            <a class="btn theme-bg-color text-white d-none d-md-block" wire:click="confirm">Konfirmasi Sekarang</a>
        </div>
    </div>
    
    <!-- Process To Next Step End -->
</div>

@push('css')
<style>
    input[type="file"]::file-selector-button {
        border-radius: 8px; 
        background-color: #FFA000; 
        color: #fff; 
        padding: 8px 12px;
        cursor: pointer; 
    }
</style>
@endpush