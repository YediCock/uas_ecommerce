<div>
    <!-- header Section Start -->
    <header class="header-style-5 header-style-6 pt-4">
        <div class="left-header">
            <h4 class="header-title">Pesanan Saya</h4>
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
    <!-- Address Section Start -->
    <section class="ecommerce-address-section pb-3">
        <div class="custom-container">
            <ul class="address-list selectionUI">
                @foreach ($userOrders as $userOrder)
                <li>
                    <div class="address-box bg-transparent" style="border: 1px solid #FFA000; border-radius: 5px;">
                        <div class="address-name pb-2" style="border-bottom: 1px solid #d3d3d3;">
                            <div class="address-icon bg-transparent text-dark">
                                <i class="fs-3 ri-shopping-bag-line"></i>
                            </div>
                            <div class="">
                                <h5>Belanja</h5>
                                <p class="mb-0">{{ $userOrder->created_at->format('d F Y') }}</p>
                            </div>
                            <div class="dropdown edit-option">
                                @if ($userOrder->status == 'unpaid')
                                    <span class="p-2 badge text-bg-danger">Belum Bayar</span>
                                @elseif ($userOrder->status == 'paid')
                                    <span class="p-2 badge text-bg-secondary">Sedang Dikemas</span>
                                @elseif ($userOrder->status == 'shipping')
                                    <span class="p-2 badge text-bg-primary">Sedang Dikirim</span>
                                @elseif ($userOrder->status == 'finish')
                                    <span class="p-2 badge text-bg-success">Selesai</span>
                                @endif
                            </div>
                        </div>
                        <div class="address-detail">
                            <h5>Alamat Pengiriman</h5>
                            <p class="h5 mb-1">{{ $userOrder->address }}</p>
                            <p class="h5 my-0"><span class="text-black">{{ $userOrder->customer_name }}</span> - {{ $userOrder->phone }}</p>
                            <p class="h5 mt-1 mb-0"><span class="text-black">Nomer Resi</span>  : {{ $userOrder->track_number ?? '-' }}</p>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <h6 class="h5 mb-0">Total Belanja</h6>
                                    <h5 class="fw-bold">Rp{{ number_format($userOrder->final_price, 0, ',', '.') }}</h5>
                                </div>
                                <div class="d-flex gap-2">
                                    @if (empty($userOrder->proof_of_payment))
                                        <a style="border: 1px solid #FFA000; color:#FFA000" href="{{ route('paymentProduct', $userOrder->id) }}" class="p-2 badge">Bayar</a>
                                    @endif
                                    @if ($userOrder->status == 'shipping')
                                    <a wire:confirm="Apakah anda yakin paket ini sudah Anda terima?"
                                        wire:click="confirmOrder({{ $userOrder->id }})"
                                        style="border: 1px solid #FFA000; color:#FFA000; cursor: pointer;" 
                                        class="p-2 badge d-flex align-items-center">
                                        Paket Sudah Diterima <i class="fw-light ms-1 ri-award-line"></i> +{{ $userOrder->calculateTotalPointsIN() }}
                                    </a>
                                    @endif
                                    <a style="background-color: #FFA000" href="{{ route('detailMyorder', $userOrder->id) }}" class="p-2 badge text-light">Detail</a>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    @if ($userOrders->isEmpty())
    <div class="text-center section-t-sm-space" style="width:100%">
        <h4>Belum ada transaksi nihh</h4>
        <a style="background-color: #FFA000" href="/product/search" class="mt-3 w-auto btn text-light btn-sm">Yuk Belanja Sekarang</a>
    </div>
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
    @endif
    {{-- product end --}}
</div>
