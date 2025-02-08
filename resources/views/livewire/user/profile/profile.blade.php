<div>
    <!-- header Section Start -->
    <header class="header-style-5 header-style-6 pt-4">
        <div class="left-header">
            <h4 class="header-title">Account</h4>
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
    <!-- Setting Section Start -->
    <section>
        <div class="custom-container">
            <div class="setting-box">
                <div class="profile-image">
                    <div class="sidebar-profile">
                        <div class="profile-image">
                            <img src="/frontend/assets/images/ecommerce/dp.jpg" class="img-fluid" alt="">
                        </div>

                        <a href="profile.html" class="profile-name">
                            <h4>{{ auth()->user()->name }}</h4>
                            <h5>{{ auth()->user()->email }}</h5>
                        </a>
                    </div>
                </div>
                <ul class="sidebar-list">
                    <li>
                        <a class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="ri-award-fill" style="margin-right: 14px !important;"></i>
                                <h5>Point Saya</h5>
                            </div>
                            <h5 class="me-1" style="color: #FFA000">Rp.{{ number_format(\App\Models\Point::getTotalPoints(auth()->user()->id), 0, ',', '.') }}</h5>
                        </a>
                    </li>
                    <li>
                        <a href="/profile/update-data">
                            <i class="ri-account-circle-fill"></i>
                            <h5>Data Pribadi</h5>
                        </a>
                    </li>

                    <li>
                        <a href="/profile/update-password">
                            <i class="ri-lock-2-fill"></i>
                            <h5>Ganti Kata Sandi</h5>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ri-logout-box-r-line"></i>
                            <h5>Keluar</h5>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>

                {{-- <a href="sign-in.html" class="btn ecommerce-btn theme-border mt-4">Logout</a> --}}
            </div>
        </div>
    </section>
    <!-- Setting Section End -->
</div>
