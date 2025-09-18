<div class="col-lg-3">
    <ul class="account-nav">
        <li><a href="{{ route('dashboard') }}" class="menu-link menu-link_us-s">Dashboard</a></li>
        <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Orders</a></li>
        <li><a href="{{ route('checkout') }}" class="menu-link menu-link_us-s">Addresses</a></li>
        {{-- <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li> --}}
        <li><a href="{{route("wishlist")}}" class="menu-link menu-link_us-s">Wishlist</a></li>
        <li>
            <form method="POST" action={{ route('logout') }}>
                @csrf
                <button type="submit" class="menu-link menu-link_us-s"
                    style="background: none; border: none; padding: 0; color: #000; cursor: pointer;">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>
