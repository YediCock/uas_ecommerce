<div>
    <!-- header Section start -->
    <header class="header-style-6 header-absolute search-header d-flex align-items-center header-style-5">
        <!-- Arrow Back Icon with Border -->
        <a href="/product/search" class="rounded-circle fw-bold title-color" style="border: 1px solid #d3d3d3; padding: 6px;">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        
        <!-- Search Input with Icon -->
        <div class="left-header header-title w-100">
            <h4 class="m-auto">Detail Produk</h4>
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
    <!-- Product Image Section Start -->
    <section class="pt-3">
        <div class="custom-container">
            <div class="swiper main-slider product-image-slider">
                <div id="gallery" class="swiper-wrapper">
                    @foreach ($product->getAsset as $imgProduct)
                    <div class="swiper-slide">
                        <div class="hes-gallery">
                            <img src="/assets/assetImage/{{ urlencode($imgProduct->image) }}" class="img-fluid w-100" alt="">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="product-color mt-3">
                <div class="swiper thumbs-image">
                    <div class="swiper-wrapper">
                        @foreach ($product->getAsset as $imgProduct)
                        <div class="swiper-slide">
                            <img src="/assets/assetImage/{{ urlencode($imgProduct->image) }}" class="img-fluid" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Image Section End -->
    <!-- Product Details Section Start -->
    <section class="section-t-space-3 product-detail-section pt-3">
        <div class="custom-container">
            
            <div class="product-name-box">
                <div class="product-name">
                    <h4>{{ $product->name }}</h4>
            
                    @if($product->discount)
                        <div class="d-flex align-items-center">
                            <h3 class="me-2">Rp.{{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}</h3> <!-- Harga setelah diskon -->
                            <div class="bg-pink text-danger p-1 rounded-pill" style="font-size: 0.6rem; background-color: #ffc0cb; color: #ff0000;">
                                <strong>{{ $product->discount }}% OFF</strong> <!-- Diskon -->
                            </div>
                        </div>
                        <del class="mt-2">Rp.{{ number_format($product->price, 0, ',', '.') }}</del> <!-- Harga normal -->
                    @else
                        <h3>Rp.{{ number_format($product->price, 0, ',', '.') }}</h3> <!-- Harga normal tanpa diskon -->
                    @endif
                </div>
                <div class="product-price">
                    <h3 wire:click="addWishlist" class="fw-bold title-color"><i class="ri-heart-3-line"></i></h3>
                </div>
            </div>
            <div class="description-box pt-3">
                <div class="title">
                    <h4>Deskripsi Produk</h4>
                    <div>{!! $product->desc !!}</div>
                </div>
            </div>
        </div>
    </section>
    <div class="listing-price-bottom">
        <div class="listing-price-button-group">
            <a href="#" data-bs-toggle="modal" data-bs-target="#detailProductModal" class="nft-btn offer-btn" wire:click="setAction('add_to_cart')">+ Keranjang</a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#detailProductModal" class="nft-btn buy-btn" wire:click="setAction('buy_now')">Beli Sekarang</a>
        </div>
    </div>
    
    <!-- Modal untuk Keranjang dan Beli Sekarang -->
    <div wire:ignore.self class="modal fade modal-bottom" id="detailProductModal" tabindex="-1" aria-labelledby="detailProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <div class="myDetailProduct d-flex align-items-center">
                        <img src="/assets/product/{{ $product->img_thumbnail }}" class="img-fluid" alt="">
                        @if($product->discount)
                            <div class="ms-3">
                                <div class="d-flex align-items-center">
                                    <h3 class="me-2">
                                        Rp.{{ number_format($finalPrice * (1 - $discount / 100), 0, ',', '.') }}
                                    </h3>
                                    <div class="text-center bg-pink text-danger p-1 rounded-pill"
                                        style="font-size: 0.6rem; background-color: #ffc0cb; color: #ff0000; width: 54px">
                                        <strong>{{ $discount }}% OFF</strong>
                                    </div>
                                </div>
                                <del class="mt-2">Rp.{{ number_format($finalPrice, 0, ',', '.') }}</del>
                            </div>
                        @else
                            <h3 class="ms-3">Rp.{{ number_format($finalPrice, 0, ',', '.') }}</h3>
                        @endif
                    </div>
                    <button type="button" class="mb-5 me-1 btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="description-content">
                        @if($product->type == 'attribute')
                            @foreach($product->getProductAttributeValues->groupBy('getAttributeValues.attribute_id') as $attributeId => $productAttributeValues)
                                @php
                                    $firstAttributeValue = $productAttributeValues->first()->getAttributeValues;
                                    $attribute = $firstAttributeValue ? $firstAttributeValue->takeAttributes : null;
                                @endphp
                                @if($attribute)
                                    <div class="product-size">
                                        <h4>{{ $attribute->name }}</h4>
                                        <ul class="mt-2 nav nav-pills tab-style-4 pb-2 m-0 border-0" role="tablist">
                                            @foreach($productAttributeValues as $productAttributeValue)
                                                @php
                                                    $value = $productAttributeValue->getAttributeValues;
                                                @endphp
                                                <li class="nav-item" role="presentation">
                                                    <button type="button" 
                                                        class="nav-link {{ $selectedAttributes[$attribute->id][$value->id]['checked'] ? 'active' : '' }}"
                                                        wire:click="selectAttributeValue({{ $attribute->id }}, {{ $value->id }}, {{ $productAttributeValue->price }})">
                                                        {{ $value->name }}
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="mb-1 product-size d-flex justify-content-between align-items-center">
                            <h4>Jumlah</h4>
                            <div class="myQuatity">
                                <div class="qty-box quantity-box">
                                    <input type="button" class="rounded-start minusBtn remove-minus count-decrease" value="-" style="border: 1px solid #d3d3d3;" wire:click="decreaseQuantity">
                                    <input wire:model="quantity" type="text" size="25" class="title-color myquantity count countdown-remove" readonly style="border: 1px solid #d3d3d3;">
                                    <input type="button" class="rounded-end plusBtn count-increase" value="+" style="border: 1px solid #d3d3d3;" wire:click="increaseQuantity">
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm theme-bg-color text-white w-100" wire:click="{{ $action == 'add_to_cart' ? 'addToCart' : 'buyNow' }}">
                        {{ $action == 'add_to_cart' ? 'Masukan Keranjang' : 'Beli Sekarang' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    
</div>
