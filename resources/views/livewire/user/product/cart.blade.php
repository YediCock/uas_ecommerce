<div>
    <!-- header Section start -->
    <header class="header-style-6 header-absolute search-header d-flex align-items-center header-style-5">
        <!-- Arrow Back Icon with Border -->
        <a href="/product/search" class="rounded-circle fw-bold title-color" style="border: 1px solid #d3d3d3; padding: 6px;">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        
        <!-- Search Input with Icon -->
        <div class="left-header header-title w-100">
            <h4 class="m-auto">Keranjang Saya</h4>
        </div>
        <div class="header-right">
            <a href="notification.html" class="notification">
                <i class="ri-notification-2-line"></i>
            </a>
        </div>
    </header>
    {{-- header Section end --}}
    <!-- Cart Section Start -->
    <section class="section-t-sm-space cart-section">
        <div class="custom-container">
            <div class="cart-items-list">
                <ul class="items-list px-0">
                    @forelse($carts as $cart)
                        <li style="border: 1px solid #d3d3d3; border-radius: 5px; padding: 10px;">
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
                                            @if($cart->getProduct->discount)
                                                <div class="d-flex align-items-center">
                                                    <!-- Menampilkan harga setelah diskon -->
                                                    <h6 class="fw-bold me-2 mb-0">
                                                        Rp.{{ number_format($cart->calculateTotalPrice($cart->getProduct->price, $cart->attributes), 0, ',', '.') }}
                                                    </h6>
                                                    <div class="mt-1 text-center bg-pink text-danger rounded-pill" style="font-size:9px; background-color: #ffc0cb; color: #ff0000; width: 54px">
                                                        <strong>{{ $cart->getProduct->discount }}% OFF</strong>
                                                    </div>
                                                </div>
                                                <!-- Menampilkan harga sebelum diskon -->
                                                <del class="mt-2" style="font-size:12px">
                                                    Rp.{{ number_format($cart->getProduct->price + $cart->calculateAdditionalPrice($cart->attributes), 0, ',', '.') }}
                                                </del>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <!-- Menampilkan harga tanpa diskon -->
                                                    <h6 class="fw-bold me-2 mb-0">
                                                        Rp.{{ number_format($cart->calculateTotalPrice($cart->getProduct->price, $cart->attributes), 0, ',', '.') }}
                                                    </h6>
                                                </div>
                                            @endif
                                        
                                        </div>
                                        <!-- Tampilkan atribut produk -->
                                        @if($cart->attributes)
                                            <h6>
                                                @foreach($cart->attributes as $attribute)
                                                    {{ $attribute['attribute_name'] }}: {{ $attribute['attribute_value'] }}.
                                                @endforeach
                                            </h6>
                                        @endif
                                        <h6>
                                            <i wire:click="addWishlist({{ $cart->getProduct->id }})" class="ri-heart-line me-3"></i><i wire:confirm="Apakah anda yakin ingin menghapus?" wire:click="deleteCart({{ $cart->id }})" class="ri-delete-bin-line"></i>
                                        </h6>
                                    </div>
                                    <div class="quantity-box">
                                        <button wire:click="updateQuantity({{ $cart->id }}, {{ $cart->quantity - 1 }})" class="btn remove-minus count-decrease mins-button minusBtn">-</button>
                                        <input class="myquantity" readonly type="number" class="stepper countdown-remove" value="{{ $cart->quantity }}">
                                        <button wire:click="updateQuantity({{ $cart->id }}, {{ $cart->quantity + 1 }})" class="btn plus-button count-increase plusBtn">+</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <div class="text-center">
                            <h4>Keranjang masih kosong</h4>
                            <a style="background-color: #FFA000" href="/product/search" class="mt-3 w-auto btn text-light btn-sm">Belanja Sekarang</a>
                        </div>
                    @endforelse            
                </ul>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->
    {{-- product start --}}
    <section class="section-t-sm-space">
        <div class="custom-container">
            <div class="title-2">
                <h4>Kamu Mungkin Juga Suka</h4>
            </div>
            <div class="product-wrapper">
                @foreach($productPopulars as $productPopulars)
                <div class="product-box border rounded" style="border-color: #d3d3d3; border-width: 1px;">
                    <div class="mb-0 product-image position-relative">
                        <a href="{{ route('detailProductUser', $productPopulars->id) }}">
                            <img src="/assets/product/{{ $productPopulars->img_thumbnail }}" class="img-fluid" alt="">
                        </a>
                        @if($productPopulars->discount)
                            <div class="position-absolute top-0 end-0 bg-pink text-danger p-1 rounded-pill mt-3 me-3" style="font-size: 0.75rem; background-color: #ffc0cb; color: #ff0000;">
                                <strong>{{ $productPopulars->discount }}% OFF</strong>
                            </div>
                        @endif
                    </div>
                    <div class="product-content p-3">
                        <a href="{{ route('detailProductUser', $productPopulars->id) }}">
                            <h5>{{ $productPopulars->name }}</h5>
                        </a>
                        @if($productPopulars->discount)
                            @php
                                $discountedPrice = $productPopulars->price - ($productPopulars->price * $productPopulars->discount / 100);
                            @endphp
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($discountedPrice) }} 
                                <span style="font-size: 0.75rem;" class="ms-0 fw-normal text-muted text-decoration-line-through">
                                    Rp.{{ number_format($productPopulars->price) }}
                                </span>
                            </h6>
                        @else
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($productPopulars->price) }}</h6>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- product end --}}
    <!-- Process To Next Step Start -->
    <div class="next-step" style="border-top: 1px solid #d3d3d3">
        <div class="left-box">
            <h6>Total</h6>
            <h4 class="text-dark">Rp. {{ number_format($totalPriceAllProduct, 0, ',', '.') }}</h4>
        </div>
        <div class="right-box d-flex align-items-center">
            <a class="me-3" wire:loading>Loading..</a>
            <a wire:click="checkoutProduct" class="btn theme-bg-color text-white">Checkout ({{ $totalQuantity }})</a>
        </div>
    </div>
    <!-- Process To Next Step End -->
</div>
