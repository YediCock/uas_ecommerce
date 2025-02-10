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
    
    <!-- Product Details Section Start -->
    <section class="section-t-space-3 product-detail-section pt-3">
        <div class="custom-container">
            <div class="product-name-box">
                <div class="product-name">
                    <h4>{{ $product->name }}</h4>
                    <h3>Rp.{{ number_format($product->price, 0, ',', '.') }}</h3>
                    <!-- Menampilkan jumlah stok -->
                    <p class="text-muted">Stok: <strong>{{ $product->stock ?? 0 }}</strong></p>
                </div>
            </div>
        </div>
    </section>
    
    <div class="listing-price-bottom">
        <div class="listing-price-button-group">
            @if (($product->stock ?? 0) > 0)
                <a href="#" data-bs-toggle="modal" data-bs-target="#detailProductModal" class="nft-btn offer-btn" wire:click="setAction('add_to_cart')">+ Keranjang</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#detailProductModal" class="nft-btn buy-btn" wire:click="setAction('buy_now')">Beli Sekarang</a>
            @else
                <button class="nft-btn disabled" disabled>Stok Habis</button>
            @endif
        </div>
    </div>
    
    <!-- Modal untuk Keranjang dan Beli Sekarang -->
    <div wire:ignore.self class="modal fade modal-bottom" id="detailProductModal" tabindex="-1" aria-labelledby="detailProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="mb-1 product-size d-flex justify-content-between align-items-center">
                        <h4>Jumlah</h4>
                        <div class="myQuatity">
                            <div class="qty-box quantity-box">
                                <input type="button" class="rounded-start minusBtn" value="-" wire:click="decreaseQuantity">
                                <input wire:model="quantity" type="text" size="25" class="title-color myquantity" readonly>
                                <input type="button" class="rounded-end plusBtn" value="+" wire:click="increaseQuantity" @if($quantity >= ($product->stock ?? 0)) disabled @endif>
                            </div>
                        </div>
                    </div>                        
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm theme-bg-color text-white w-100" wire:click="{{ $action == 'add_to_cart' ? 'addToCart' : 'buyNow' }}" @if($quantity > ($product->stock ?? 0)) disabled @endif>
                        {{ $action == 'add_to_cart' ? 'Masukan Keranjang' : 'Beli Sekarang' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
