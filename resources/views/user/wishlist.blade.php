@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Wishlist</h2>
            <div class="checkout-steps">
                <a href="{{route('cart')}}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="{{ route('checkout') }}" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="#" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>
            <div class="shopping-cart">
                @if (session()->has('wishlist') && count(session('wishlist')) > 0)
                    <div class="cart-table__wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy" src="{{ asset('uploads/product/' . $item['image']) }}"
                                                    width="120" height="120" alt="" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $item['name'] }}</h4>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">Rs{{ $item['price'] }}</span>
                                        </td>
                                        <td>
                                            {{ $item['quantity'] }} kg
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <form method="POST"
                                                        action="{{ route('wishlist.move.cart', ['id' => $item['id']]) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning">Move to
                                                            Cart</button>
                                                    </form>
                                                </div>


                                                <div class="col-6">
                                                    <form method="POST"
                                                        action="{{ route('wishlist.remove', $item['id']) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0)" class="remove-wishlist">
                                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                                fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                                <path
                                                                    d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                            </svg>
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form method="POST" action="{{ route('wishlist.empty') }}">
                            @csrf
                            @method('DELETE')
                            <div class="cart-table-footer">
                                <button class="btn btn-light">CLEAR WISHLIST</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center pt-5 bp-5">
                            <p>No item Found In Your Wishlist</p>
                            <a href="{{ route('shop') }}" class="btn btn-info">Wishlist Now</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
    @include('user.components.footer')
@endsection
@push('scripts')
    <script>
        $(function() {
            $('.remove-wishlist').on("click", function() {
                $(this).closest('form').submit();
            });
        })
    </script>
@endpush
