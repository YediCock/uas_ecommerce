<!-- Onboarding Button Start -->
<div class="blogging-onboarding">
    <div class="onboarding-image">
        <img src="/frontend/assets/images/my-image/login.jpg" class="img-fluid" alt="">
    </div>

    <div class="author-box-9">
        <div class="w-100">
            <h2>Register</h2>
            <form class="form-style-9 w-100" wire:submit="registerCurrentUser">
                <div class="form-box">
                    <input wire:model="name" type="text" class="form-control" placeholder="Nama">
                    <i class="ri-user-3-line"></i>
                </div>
                @error('name') <span class="text-white">{{ $message }}</span> @enderror
                <div class="form-box">
                    <input wire:model="phone" type="number" class="form-control" id="phone" placeholder="Nomer Telepon">
                    <i class="ri-phone-line"></i>
                </div>
                @error('phone') <span class="text-white">{{ $message }}</span> @enderror
                <div class="form-box">
                    <input wire:model="email" type="email" class="form-control" id="email" placeholder="Email">
                    <i class="ri-at-line"></i>
                </div>
                @error('email') <span class="text-white">{{ $message }}</span> @enderror
                <div class="form-box">
                    <input wire:model="password" type="password" class="form-control" id="password" placeholder="Password">
                    <i class="ri-lock-2-line"></i>
                </div>
                @error('password') <span class="text-white">{{ $message }}</span> @enderror
                <div class="form-box">
                    <input wire:model="confirm_password" type="password" class="form-control" id="password" placeholder="Konfirmasi Password">
                    <i class="ri-lock-2-line"></i>
                </div>
                @error('confirm_password') <span class="text-white">{{ $message }}</span> @enderror
                <button class="blog-btn dark-btn mt-29 d-block text-center">Register</button>
                <a href="/login" class="other-author"> Sudah punya Akun? Login</a>
            </form>
        </div>
    </div>
</div>
<!-- Onboarding Button End -->
