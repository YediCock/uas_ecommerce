<div>
    <!-- header Section Start -->
    <header class="header-style-5 header-style-6 pt-4">
        <div class="left-header">
            <a href="/" class="d-flex">
                {{-- <img src="/frontend/assets/images/logo/7.svg" class="img-fluid" alt=""> --}}
                <img src="/frontend/assets/images/logo/logoSkincare-preview.png" class="img-fluid" alt="">
                <h4 class="">SkincareStore</h4>
            </a>
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
    {{-- search bar start --}}
    <section>
        <div class="custom-container mt-1">
            <a href="/product/search" id="searchLink">
                <form class="form-style-6" onsubmit="return false;">
                    <div class="search-box">
                        <input type="search" class="form-control" placeholder="Cari produk disini.." readonly>
                        <i class="ri-search-2-line"></i>
                    </div>
                </form>
            </a>
        </div>
    </section>
    {{-- search bar end --}}

    {{-- banner start --}}
    <section class="section-t-space banner-section pt-1">
        <div class="swiper mx-3 slider-1-1 white-dots swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                    <div class="swiper-slide">
                        <div class="banner-box">
                            <a href="{{ $banner->url ?? '#' }}">
                                <img src="/assets/banner/{{ $banner->image }}" class="img-fluid banner-image" alt="">
                                <div class="banner-content w-50 p-center">
                                    <div>
                                        <h4 class="text-white" style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);font-weight: bold;">{{ $banner->title ?? '' }}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); z-index: 10;"></div>
        </div>
    </section>
    {{-- banner end --}}
    {{-- category start --}}
    <section class="section-t-sm-space food-category-section">
        <div class="swiper category-slider px-15">
            <div class="swiper-wrapper">
                @foreach($categories as $index => $ctg)
                <div class="swiper-slide" role="group" aria-label="{{ $index + 1 }} / 6" style="width: 142.632px;">
                    <a href="{{ route('searchProduct', ['category' => $ctg->id]) }}"  class="food-category-box" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                        <div class="category-image" style="border: 2px solid #d3d3d3; border-radius: 50%; padding: 5px; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <img src="/assets/category/{{ $ctg->icon }}" style="max-width: 58%; max-height: 100%; border-radius: 50%;" alt="">
                        </div>
                        <h5 style="margin-top: 5px;">{{ $ctg->name }}</h5>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- category end --}}
    {{-- product populer start --}}
    <section class="section-t-sm-space feature-section ">
        <div class="title-2 px-15">
            <h4>Jelajahi Unggulan Kami</h4>
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
    <!-- Product Section Start -->
    <section class="section-t-sm-space">
        <div class="custom-container">
            <div class="title-2">
                <h4>Produk Terbaru Buat Kamu</h4>
                <a href="/product/search" style="color: #FFA000">Lihat semua</a>
            </div>
            <div class="product-wrapper">
                @foreach($productNotPopulars as $index => $productNotPopular)
                <div class="product-box border rounded" style="border-color: #d3d3d3; border-width: 1px;">
                    <div class="mb-0 product-image position-relative">
                        <a href="{{ route('detailProductUser', $productNotPopular->id) }}">
                            <img src="/assets/product/{{ $productNotPopular->img_thumbnail }}" class="img-fluid" alt="">
                        </a>
                        @if($productNotPopular->discount)
                            <div class="position-absolute top-0 end-0 bg-pink text-danger p-1 rounded-pill mt-3 me-3" style="font-size: 0.75rem; background-color: #ffc0cb; color: #ff0000;">
                                <strong>{{ $productNotPopular->discount }}% OFF</strong>
                            </div>
                        @endif
                    </div>
                    <div class="product-content p-3">
                        <a href="{{ route('detailProductUser', $productNotPopular->id) }}">
                            <h5>{{ $productNotPopular->name }}</h5>
                        </a>
                        @if($productNotPopular->discount)
                            @php
                                $discountedPrice = $productNotPopular->price - ($productNotPopular->price * $productNotPopular->discount / 100);
                            @endphp
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($discountedPrice) }} 
                                <span style="font-size: 0.75rem;" class="ms-0 fw-normal text-muted text-decoration-line-through">
                                    Rp.{{ number_format($productNotPopular->price) }}
                                </span>
                            </h6>
                        @else
                            <h6 class="mt-2 fw-bold fs-6">Rp.{{ number_format($productNotPopular->price) }}</h6>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->
    {{-- testimonial start --}}
    <section class="section-t-sm-space">
        <div class="container">
            <div class="title-2">
                <h4>Testimonial</h4>
            </div>
            <div class="swiper brand-slider">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="card border-light">
                            <div class="card-body text-center p-0">
                                <img src="/assets/testimonial/{{ $testimonial->image }}" class="img-fluid rounded-circle mb-3" alt="Profile Image" style="width: 80px; height: 80px;">
                                <h5 class="card-title mb-1">{{ $testimonial->name }}</h5>
                                <p class="card-text">"{{ $testimonial->desc }}"</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- testimonial end --}}
    {{-- article start --}}
    <section class="section-t-sm-space feature-section">
        <div class="title-2 px-15">
            <h4>Artikel</h4>
            <a href="/article" style="color: #FFA000">Lihat semua</a>
        </div>

        <div class="swiper feature-slider2 px-15">
            <div class="swiper-wrapper">
                @foreach($articles as $article)
                <div class="swiper-slide">
                    <div class="feature-box">
                        <a href="{{ route('detailArticleUser', $article->id) }}" class="feature-head">
                            <img src="/assets/article/{{ $article->img_thumbnail }}" class="img-fluid" alt="">
                        </a>

                        <div class="feature-content">
                            <a href="{{ route('detailArticleUser', $article->id) }}">
                                <h5>{{ $article->name }}</h5>
                            </a>
                            <h6>{{ $article->created_at->translatedFormat('d F Y') }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- article end --}}
</div>
