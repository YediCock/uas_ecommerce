<div>
    <!-- header Section start -->
    <header class="header-style-6 header-absolute search-header d-flex align-items-center header-style-5">
        <!-- Arrow Back Icon with Border -->
        <a href="/myorder" class="rounded-circle fw-bold title-color" style="border: 1px solid #d3d3d3; padding: 6px;">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        
        <!-- Search Input with Icon -->
        <div class="left-header header-title w-100">
            <h4 class="m-auto">Detail Pesanan</h4>
        </div>
        <div class="header-right me-3">
            <a href="notification.html" class="notification">
                <i class="ri-notification-2-line"></i>
            </a>
            @if (auth()->check())
            <a href="{{ route('detailCart', auth()->user()->id) }}" class="my-cart-icon">
                <i class="ri-shopping-cart-line"></i>
                @if ($this->cartCount > 0)
                    <span class="my-cart-count fw-bold">{{ $this->cartCount }}</span>
                @endif
            </a>
            @else
                <a href="/login" class="my-cart-icon">
                    <i class="ri-shopping-cart-line"></i>
                </a>
            @endif
        </div>        
    </header>
    {{-- header section end --}}
    @include('livewire.user.partials.navbar-bottom')
    <!-- Address Section Start -->
    <section class="ecommerce-address-section pb-3">
        <div class="custom-container">
            <ul class="address-list selectionUI">
                <li>
                    <div class="address-box bg-transparent px-0 pt-3 mt-1 pb-0">
                        <div class="address-name">
                            <div class="">
                                <h5>Status Pesanan</h5>
                            </div>
                            <div class="dropdown edit-option">
                                @if ($userOrder->status == 'unpaid')
                                    <h5 class="fw-bold">Belum Bayar</h5>
                                @elseif ($userOrder->status == 'packed')
                                    <h5 class="fw-bold">Sedang Dikemas</h5>
                                @elseif ($userOrder->status == 'shipping')
                                    <h5 class="fw-bold">Sedang Dikirim</h5>
                                @elseif ($userOrder->status == 'finished')
                                    <h5 class="fw-bold">Selesai</h5>
                                @endif
                            </div>
                        </div>
                        <div class="address-name">
                            <div class="">
                                <h5>Tanggal Pembelian</h5>
                            </div>
                            <div class="dropdown edit-option">
                                <h5 class="text-secondary">{{ $userOrder->created_at->format('d F Y') }}</h5>
                            </div>
                        </div>
                        <div class="address-name">
                            <div class="">
                                <h5>Kurir</h5>
                            </div>
                            <div class="dropdown edit-option">
                                <h5 class="text-secondary">{{ $userOrder->shipping_courier }} - {{ $userOrder->shipping_service_name }}</h5>
                            </div>
                        </div>
                        <div class="address-name pb-3 mb-0" style="border-bottom: 1px solid #d3d3d3;">
                            <div class="">
                                <h5>Nomer Resi</h5>
                            </div>
                            <div class="dropdown edit-option">
                                <h5 class="text-secondary">{{ $userOrder->track_number ?? '-' }}</h5>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- Address Section End -->
    <!-- Cart Section Start -->
    <section class="cart-section">
        <div class="custom-container">
            <div class="title-2 mb-1">
                <h4>Detail Produk</h4>
            </div>
            <div class="cart-items-list">
                <ul class="items-list px-0">
                    @foreach($userOrder->getCart as $cart)
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
    <!-- Address List Section Start -->
    <section class="address-section">
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
                                    <p class="text-black my-2 lh-sm">{{ $userOrder->address }}</p>
                                    <p><span class="text-black">{{ $userOrder->customer_name }}</span> - {{ $userOrder->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Address List Section End -->
    <section class="section-t-sm-space pb-3">
        <div class="custom-container">
            <div class="title-2 mb-3">
                <h4>Rincian Pembayaran</h4>
            </div>
            <div class="order-detail-box mt-0 pt-0">
                <ul class="order-price-list">
                    <li>
                        <div class="order-price-box">
                            <h4 class="name">Subtotal ({{ $userOrder->getCart->sum('quantity') }} produk)</h4>
                            <h4 class="price">Rp.{{ number_format($userOrder->total_price, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                    @if($userOrder->point_out > 0)
                    <li>
                        <div class="order-price-box">
                            <h4 class="name">Penukaran Point Belanja</h4>
                            <h4 class="price" style="color: #FFA000">-Rp.{{ number_format($userOrder->point_out, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                    @endif
                    <li>
                        <div class="order-price-box">
                            <h4 class="name">Total Biaya Pengiriman</h4>
                            <h4 class="price">Rp.{{ number_format($userOrder->shipping_cost, 0, ',', '.') }}</h4>
                        </div>
                    </li>

                    <li>
                        <div class="order-price-box">
                            <h4 class="name">PPN {{ $userOrder->tax }}%</h4>
                            <h4 class="price">Rp.{{ number_format($userOrder->tax_amount, 0, ',', '.') }}</h4>
                        </div>
                    </li>

                    <li class="total-price">
                        <div class="order-price-box">
                            <h4 class="fw-bold fs-6">Total Belanja</h4>
                            <h4 class="price fs-6">Rp.{{ number_format($userOrder->final_price, 0, ',', '.') }}</h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    {{-- product populer start --}}
    <section class="section-t-sm-space feature-section ">
        <div class="title-2 px-15">
            <h4>Rekomendasi Untukmu</h4>
        </div>

        <div class="swiper feature-slider px-15">
            <div class="swiper-wrapper">
                @foreach($productPopulars as $index => $productPopular)
                    <div class="swiper-slide product-wrapper">
                        <div class="product-box border rounded" style="border-color: #d3d3d3; border-width: 1px;">
                            <div class="mb-0 product-image position-relative">
                                <a href="{{ route('detailProductUser', $productPopular->id) }}">
                                    <img src="/assets/product/{{ $productPopular->img_thumbnail }}" class="img-fluid" alt="">
                                </a>
                
                                @if($productPopular->discount)
                                    <div class="position-absolute top-0 end-0 bg-pink text-danger p-1 rounded-pill mt-3 me-3" style="font-size: 0.75rem; background-color: #ffc0cb; color: #ff0000;">
                                        <strong>{{ $productPopular->discount }}% OFF</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="product-content p-3">
                                <a href="{{ route('detailProductUser', $productPopular->id) }}">
                                    <h5>{{ $productPopular->name }}</h5>
                                </a>
                                @if($productPopular->discount)
                                    @php
                                        $discountedPrice = $productPopular->price - ($productPopular->price * $productPopular->discount / 100);
                                    @endphp
                                    <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($discountedPrice) }} 
                                        <span style="font-size: 0.75rem;" class="ms-0 fw-normal text-muted text-decoration-line-through">
                                            Rp.{{ number_format($productPopular->price) }}
                                        </span>
                                    </h6>
                                @else
                                    <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($productPopular->price) }}</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>    
    {{-- product populer end --}}
</div>  
