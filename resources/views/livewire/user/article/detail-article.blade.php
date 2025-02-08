<div>
    <!-- header Section Start -->
    <header class="header-style-absolute">
        <div class="custom-container">
            <div class="left-header">
                <a href="/article">
                    <i class="ri-arrow-left-line"></i>
                </a>
            </div>

            <ul class="right-right me-1">
                <li>
                    <a href="javascript:void(0)">
                        <i class="ri-share-line"></i>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="heart-box">
                        <i class="ri-notification-2-line"></i>
                    </a>
                </li>
                <li>
                    @if (auth()->check())
                        <a href="{{ route('detailCart', auth()->user()->id) }}" id="heart-box" class="my-cart-icon">
                            <i class="ri-shopping-cart-line"></i>
                            @if ($this->cartCount > 0)
                                <span class="my-cart-count fw-bold" style="top: -5px;right: -5px; ">{{ $this->cartCount }}</span>
                            @endif
                        </a>
                    @else
                        <a href="/login" class="my-cart-icon">
                            <i class="ri-shopping-cart-line"></i>
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </header>
    <!-- header Section End -->
    {{-- header section end --}}
    @include('livewire.user.partials.navbar-bottom')
    <!-- Blog Listing Section Start -->
    <!-- Room View Section Start -->
    <section class="room-view-section">
        <div class="swiper room-view-slider room-view-image rounded-0">
            <div class="swiper-wrapper">
                @foreach ($article->getAsset as $imgArticle)
                <div class="swiper-slide">
                    <div class="room-image">
                        <img src="/assets/assetImage/{{ $imgArticle->image }}" alt="" class="img-fluid">
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- Room View Section End -->
    <!-- Single Blog Details Start -->
    <section>
        <div class="custom-container">
            <div class="single-blog-details">
                <h4>{{ $article->name }}</h4>
                <ul class="date-time-list">
                    <li>{{ $article->created_at->translatedFormat('d F Y') }}</li>
                </ul>
            </div>
            @if ($article->url_yt) 
                <div class="single-blog-container mb-4">
                    <div class="video-container">
                        <iframe width="100%" height="250" src="{{ str_replace('watch?v=', 'embed/', $article->url_yt) }}" 
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif
            <div class="single-blog-container">
                <div class="quotes-details">
                    {!! $article->desc !!}
                </div>
            </div>
        </div>
    </section>
    <!-- Single Blog Details End -->
</div>
