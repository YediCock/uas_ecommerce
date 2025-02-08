<div>
    <!-- header Section start -->
    <header class="header-style-6 header-absolute search-header d-flex align-items-center header-style-5">
        <!-- Arrow Back Icon with Border -->
        <a href="/profile" class="rounded-circle fw-bold title-color" style="border: 1px solid #d3d3d3; padding: 6px;">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        
        <!-- Search Input with Icon -->
        <div class="left-header header-title w-100">
            <h4 class="m-auto">Informasi Pribadi</h4>
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
    {{-- header Section end --}}
    <!-- Edit Profile Section Start -->
    <section class="section-t-space edit-profile-section">
        <div class="custom-container">
            <div class="edit-image">
                <div class="profile-pic">
                    <input id="file" type="file" onchange="loadFile(event)">
                    <img src="/frontend/assets/images/learning/menu-profile.jpg" id="output" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Edit Profile Section End -->

    <!-- account name section start -->
    <section class="section-t-space account-name-section section-b-space">
        <div class="custom-container">
            <div class="acount-form-box">
                <form class="form-style-9" wire:submit="updateProfile">
                    <div class="form-box mb-3">
                        <label for="fname" class="form-label fw-semibold">Nama</label>
                        <input wire:model="name" type="text" class="form-control" id="fname">
                    </div>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="form-box mb-3">
                        <label for="lname" class="form-label fw-semibold">Nomer Telepon</label>
                        <input wire:model="phone" type="number" class="form-control" id="lname">
                    </div>
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="form-box mb-3">
                        <label for="bio" class="form-label fw-semibold">Email</label>
                        <input wire:model="email" type="email" class="form-control" id="lname">
                    </div>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    <button class="mt-4 btn btn-sm theme-bg-color text-white w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </section>
    <!-- account name section end -->
</div>
