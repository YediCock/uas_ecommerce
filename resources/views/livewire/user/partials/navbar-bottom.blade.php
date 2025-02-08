<!-- Mobile Section Start -->
<div class="mobile-style-8">
    <ul>
        <li class="@if($activeTab == 'home') active @endif">
            <a href="/" wire:click="selectTab('home')">
                <i class="ri-home-6-line"></i>
                <h6>Home</h6>
            </a>
        </li>
        <li class="@if($activeTab == 'search') active @endif">
            <a href="/product/search" wire:click="selectTab('search')">
                <i class="ri-search-line"></i>
                <h6>Search</h6>
            </a>
        </li>
        <li class="@if($activeTab == 'order') active @endif">
            <a href="/myorder" wire:click="selectTab('order')">
                <i class="ri-article-line"></i>
                <h6>Order</h6>
            </a>
        </li>
        <li class="@if($activeTab == 'wishlist') active @endif">
            <a href="/wishlist" wire:click="selectTab('wishlist')">
                <i class="ri-heart-3-line"></i>
                <h6>Wishlist</h6>
            </a>
        </li>
        <li class="@if($activeTab == 'profile') active @endif">
            <a href="/profile">
                <i class="ri-user-3-line"></i>
                <h6>Profile</h6>
            </a>
        </li>
    </ul>
</div>
<!-- Mobile Section End -->