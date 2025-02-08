<div>
    <!-- header Section start -->
    <header class="header-style-6 header-absolute search-header d-flex align-items-center header-style-5">
        <!-- Arrow Back Icon with Border -->
        <a href="/" class="rounded-circle fw-bold title-color" style="border: 1px solid #d3d3d3; padding: 6px;">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        
        <!-- Search Input with Icon -->
        <div class="input-group">
            <!-- Search Icon with Border -->
            <span class="input-group-text" style="border: 1px solid #d3d3d3; border-right: none; background-color: transparent !important">
                <i class="ri-search-line"></i>
            </span>
            <!-- Search Input -->
            <input wire:model.live="search" type="text" class="form-control" placeholder="cari produk disini.." style="border: 1px solid #d3d3d3; border-left: none;">
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
    {{-- filter strart --}}
    <div class="category-section pt-2">
        <ul class="category-box overflow-auto px-15">
            <li>
                <ul class="category-list">
                    <li>
                        <a href="#" wire:click.prevent="resetFilter()">Reset Filter</a>
                    </li>
                    <li class="@if($selectedFilter == 'all') active @endif">
                        <a href="#" wire:click.prevent="selectFilter('all')">Semua Produk</a>
                    </li>
                    <li class="@if($selectedFilter == 'discount') active @endif">
                        <a href="#" wire:click.prevent="selectFilter('discount')">Diskon</a>
                    </li>
                    <li class="@if($selectedFilter == 'newest') active @endif">
                        <a href="#" wire:click.prevent="selectFilter('newest')">Terbaru</a>
                    </li>
                    <li class="@if($selectedFilter == 'low_to_high') active @endif">
                        <a href="#" wire:click.prevent="selectFilter('low_to_high')">Paling Murah</a>
                    </li>
                    <li class="@if($selectedFilter == 'high_to_low') active @endif">
                        <a href="#" wire:click.prevent="selectFilter('high_to_low')">Paling Mahal</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    {{-- filter end --}}
    {{-- category start --}}
    <section class="pt-2">
        <div class="custom-container">
            <ul class="nav nav-pills tab-style-4 pb-2 m-0 border-0" role="tablist">
                @foreach($categories as $ctg)
                <li class="nav-item" role="presentation">
                    <button wire:click="selectCategory({{ $ctg->id }})" class="nav-link @if($selectedCategory == $ctg->id) active @endif" type="button" role="tab">{{ $ctg->name }}</button>
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    {{-- category end --}}
    {{-- product start --}}
    <section class="section-t-sm-space">
        <div class="custom-container">
            @if($selectedCategory)
                @if($products->isEmpty())
                    <div class="title-2">
                        <h4>Produk kategori {{ $selectedCategoryName }} belum ada</h4>
                    </div>
                @else
                    <div class="title-2">
                        <h4>Semua produk {{ $selectedCategoryName }}</h4>
                    </div>
                @endif
            @else
                <div class="title-2">
                    <h4>Rekomendasi buat kamu</h4>
                </div>
            @endif
            <div style="grid-template-columns: repeat(2, 1fr) !important;" class="product-wrapper">
                @foreach($products as $product)
                <div class="product-box border rounded" style="border-color: #d3d3d3; border-width: 1px;">
                    <div class="mb-0 product-image position-relative">
                        <a href="{{ route('detailProductUser', $product->id) }}">
                            <img src="/assets/product/{{ $product->img_thumbnail }}" class="img-fluid" alt="">
                        </a>
                        @if($product->discount)
                            <div class="position-absolute top-0 end-0 bg-pink text-danger p-1 rounded-pill mt-3 me-3" style="font-size: 0.75rem; background-color: #ffc0cb; color: #ff0000;">
                                <strong>{{ $product->discount }}% OFF</strong>
                            </div>
                        @endif
                    </div>
                    <div class="product-content p-3">
                        <a href="{{ route('detailProductUser', $product->id) }}">
                            <h5>{{ $product->name }}</h5>
                        </a>
                        @if($product->discount)
                            @php
                                $discountedPrice = $product->price - ($product->price * $product->discount / 100);
                            @endphp
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($discountedPrice) }} 
                                <span style="font-size: 0.75rem;" class="ms-0 fw-normal text-muted text-decoration-line-through">
                                    Rp.{{ number_format($product->price) }}
                                </span>
                            </h6>
                        @else
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($product->price) }}</h6>
                        @endif
                    </div>
                </div>
                @endforeach
                <!-- Placeholder untuk mengisi kolom kedua -->
                @if(count($products) % 2 !== 0)
                <div class="product-box my-product-placeholder"></div>
                @endif
            </div>
        </div>
    </section>
    {{-- product end --}}
    @if (count($products) >= $limitData)
        <div class="text-center mt-2">
            <button style="background-color: #FFA000" class="mt-3 w-auto btn text-light btn-sm _effect--ripple waves-effect waves-light" wire:loading><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>
            <button style="background-color: #FFA000" type="submit" class="mt-3 w-auto btn text-light btn-sm _effect--ripple waves-effect waves-light" wire:click.prevent="addLimitData" wire:loading.remove>Selanjutnya..</button>
        </div>
    @endif
</div>
