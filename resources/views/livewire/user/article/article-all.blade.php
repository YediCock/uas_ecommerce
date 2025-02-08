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
            <input wire:model.live="search" type="text" class="form-control" placeholder="cari artikel disini.." style="border: 1px solid #d3d3d3; border-left: none;">
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
    <!-- Blog Listing Section Start -->
    <section class="section-t-space-3">
        <div class="custom-container">
            <div class="title-2">
                <h4 class="title-color">Semua Artikel</h4>
            </div>

            <ul class="category-content-list">
                @foreach($articles as $article)
                <li>
                    <div class="category-content-box">
                        <a href="{{ route('detailArticleUser', $article->id) }}" class="category-content-image">
                            <img src="/assets/article/{{ $article->img_thumbnail }}" class="img-fluid h-100 w-100" style="height: 280px; object-fit: cover;" alt="">
                        </a>
                        <div class="category-content-content">
                            <a href="{{ route('detailArticleUser', $article->id) }}">
                                <h6>{{ $article->name }}</h6>
                            </a>
                            <ul class="time-zone-list">
                                <li>
                                    <div class="time-zone-box">
                                        <i class="ri-time-line"></i>
                                        <span>{{ $article->created_at->translatedFormat('d F Y') }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>                
                @endforeach
            </ul>
        </div>
    </section>
    <!-- Blog Listing Section End -->
    @if (count($articles) >= $limitData)
        <div class="text-center mt-2">
            <button style="background-color: #FFA000" class="mt-3 w-auto btn text-light btn-sm _effect--ripple waves-effect waves-light" wire:loading><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>
            <button style="background-color: #FFA000" type="submit" class="mt-3 w-auto btn text-light btn-sm _effect--ripple waves-effect waves-light" wire:click.prevent="addLimitData" wire:loading.remove>Selanjutnya..</button>
        </div>
    @endif
</div>
