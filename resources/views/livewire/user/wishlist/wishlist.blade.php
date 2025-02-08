<div>
    <!-- header Section Start -->
    <header class="header-style-5 header-style-6 pt-4">
        <div class="left-header">
            <h4 class="header-title">Semua Wishlist</h4>
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
    <!-- header Section End -->
    @include('livewire.user.partials.navbar-bottom')
    <!-- Product Section Start -->
    <section>
        <div class="custom-container">
            <div class="product-wrapper" style="grid-template-columns: repeat(2, 1fr) !important;">
                @foreach ($userWishlists as $wishlist)
                <div class="product-box border rounded" style="border-color: #d3d3d3; border-width: 1px;">
                    <div class="mb-0 product-image position-relative">
                        <a href="{{ route('detailProductUser', $wishlist->getProduct->id) }}">
                            <img src="/assets/product/{{ $wishlist->getProduct->img_thumbnail }}" class="img-fluid" alt="">
                        </a>
                        <ul class="add-icon-list">
                            <li>
                                <a wire:click="deleteWishlist({{ $wishlist->getProduct->id }})" wire:confirm="Apakah anda yakin ingin menghapus?">
                                    <i class="text-white ri-delete-bin-7-line"></i>
                                </a>
                            </li>
                        </ul>
                        @if($wishlist->getProduct->discount)
                            <div class="position-absolute top-0 end-0 bg-pink text-danger p-1 rounded-pill mt-3 me-3" style="font-size: 0.75rem; background-color: #ffc0cb; color: #ff0000;">
                                <strong>{{ $wishlist->getProduct->discount }}% OFF</strong>
                            </div>
                        @endif
                    </div>
                    <div class="product-content p-3">
                        <a href="{{ route('detailProductUser', $wishlist->getProduct->id) }}">
                            <h5>{{ $wishlist->getProduct->name }}</h5>
                        </a>
                        @if($wishlist->getProduct->discount)
                            @php
                                $discountedPrice = $wishlist->getProduct->price - ($wishlist->getProduct->price * $wishlist->getProduct->discount / 100);
                            @endphp
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($discountedPrice) }} 
                                <span style="font-size: 0.75rem;" class="ms-0 fw-normal text-muted text-decoration-line-through">
                                    Rp.{{ number_format($wishlist->getProduct->price) }}
                                </span>
                            </h6>
                        @else
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($wishlist->getProduct->price) }}</h6>
                        @endif
                    </div>
                </div>
                @endforeach
                <!-- Placeholder untuk mengisi kolom kedua -->
                @if(count($userWishlists) % 2 !== 0)
                <div class="product-box my-product-placeholder"></div>
                @endif
            </div>
        </div>
    </section>
    <!-- Product Section End -->
    @if ($userWishlists->isEmpty())
    <div class="text-center section-t-sm-space" style="width:100%">
        <h4>Belum ada produk yang kamu suka nihh</h4>
        <a style="background-color: #FFA000" href="/product/search" class="mt-3 w-auto btn text-light btn-sm">Yuk Cari Produk Sekarang</a>
    </div>
    @endif
    {{-- product start --}}
    <section class="section-t-sm-space">
        <div class="custom-container">
            <div class="title-2">
                <h4>Kamu Mungkin Juga Suka</h4>
            </div>
            <div class="product-wrapper">
                @foreach($productPopulars as $productPopular)
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
                @endforeach
            </div>
        </div>
    </section>  
    {{-- product end --}}
</div>
