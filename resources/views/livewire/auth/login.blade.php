<!-- Onboarding Button Start -->
<div class="blogging-onboarding">
    <div class="onboarding-image">
        <img src="/frontend/assets/images/my-image/login.jpg" class="img-fluid" alt="">
    </div>

    <div class="author-box-9">
        <div class="w-100">
            <h2>Login</h2>
            <form class="form-style-9 w-100" wire:submit.prevent="loginCurrentUser">
                <div class="form-box">
                    <input type="text" wire:model="email" class="form-control" id="email" placeholder="Email atau nomer telepon">
                    <i class="ri-at-line"></i>
                </div>
                @error('email') <span class="text-white">{{ $message }}</span> @enderror
                <div class="form-box">
                    <input type="password" wire:model="password" class="form-control" id="password" placeholder="Password">
                    <i class="ri-lock-2-line"></i>
                </div>
                {{-- <a href="forgot-password.html" class="forgot-text">Forgot password?</a> --}}
                <button type="submit" class="mt-5 blog-btn dark-btn d-block text-center">Login</button>

                <a href="/register" class="other-author">Belum punya Akun? Register</a>
            </form>
        </div>
    </div>
</div>
<!-- Onboarding Button End -->