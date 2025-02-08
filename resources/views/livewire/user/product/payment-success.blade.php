<div>
    <!-- Order Success Section Start -->
    <section class="ecommerce-order-success-section">
        <div class="custom-container">
            <div class="order-success-image">
                <img src="/frontend/assets/images/ecommerce/tick.gif" class="img-fluid" alt="">
            </div>
            <div class="success-content">
                <h2>Pesanan berhasil!</h2>
                <p>Kami akan memeriksa pesanan anda <br> Silahkan cek order secara berkala.</p>
            </div>
            <div class="">
                <a style="border: 1px solid #FFA000; color: #FFA000" href="/product/search" class="mt-3 w-auto btn btn-lg me-3">Lanjut Belanja</a>
                <a style="background-color: #FFA000" href="/myorder" class="mt-3 w-auto btn text-light btn-lg">Lihat Pesanan</a>
            </div>
        </div>
    </section>
    <!-- Order Success Section End -->
    @include('livewire.user.partials.navbar-bottom')
    {{-- product start --}}
    <section class="section-t-sm-space">
        <div class="custom-container">
            <div class="title-2">
                <h4>Produk baru untukmu!</h4>
            </div>
            <div class="product-wrapper">
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
            </div>
        </div>
    </section>
    {{-- product end --}}
</div>
