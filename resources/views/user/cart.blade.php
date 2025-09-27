@extends('user.components.master')

@section('content')
    @include('user.components.navbar')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Cart</h2>

            <div class="checkout-steps">
                <a href="{{ route('cart') }}" class="checkout-steps__item active">
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
                <a href="" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>

            <div class="shopping-cart">
                @if (session()->has('cart') && count(session('cart')) > 0)
                    @php
                        $items = session('cart');
                        $subtotal = 0;
                    @endphp

                    <div class="cart-table__wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php
                                        $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                                        $price = isset($item['price']) ? (float) $item['price'] : 0;
                                        $itemSubtotal = $price * $quantity;
                                        $subtotal += $itemSubtotal;
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/product/' . ($item['image'] ?? 'default.png')) }}"
                                                    width="120" height="120" alt="" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $item['name'] ?? 'No Name' }}</h4>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">Rs{{ number_format($price, 2) }}</span>
                                        </td>
                                        <td>
                                            <div class="qty-control position-relative">
                                                <input type="number" name="quantity" value="{{ $quantity ?? 1 }}" min="1"
                                                    class="qty-control__number text-center"
                                                    style="width:90px; padding-right:30px; text-align:center;">
                                                     <span style="position:absolute; right: 30px; top:5%; transform:translateY(50%); pointer-events:none;">
                                                    kg </span>
                                                <form method="POST" action="{{ route('cart.qty.decrease', $item['id']) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__reduce">-</div>
                                                </form>
                                                </span>
                                                <form method="POST" action="{{ route('cart.qty.increase', $item['id']) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__increase" style="left: 90px;">+</div>
                                                </form>

                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__subtotal">Rs{{ number_format($itemSubtotal, 2) }}</span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:void(0)" class="remove-cart">
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path
                                                            d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="cart-table-footer">
                            @if (!session()->has('coupon'))
                                <form action="{{ route('apply.coupon.code') }}" method="POST" class="position-relative bg-body">
                                    @csrf
                                    <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" required>
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                        value="APPLY COUPON">
                                </form>
                            @else
                                <form action="{{ route('remove_coupon_code') }}" method="POST" class="position-relative bg-body">
                                    @method('DELETE')
                                    @csrf
                                    <input class="form-control" type="text" name="coupon_code"
                                        value="{{ session('coupon')['code'] . ' Applied!' }}" readonly>
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                        value="REMOVE COUPON">
                                </form>
                            @endif

                            <form method="POST" action="{{ route('cart.empty') }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light" type="submit">CLEAR CART</button>
                            </form>

                            @if (session('success'))
                                <div
                                    style="color: green; background-color: #eafae3; padding: 10px; border-radius: 5px;  margin-top: 10px;">
                                    ✔️ {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div
                                    style="color: red; background-color: #ffe6e6; padding: 10px; border-radius: 5px;  margin-top: 10px;">
                                    ❌ {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="shopping-cart__totals-wrapper">
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">
                                <h3>Cart Totals</h3>

                                {{-- @php
                                $vatPercentage = 15;
                                @endphp --}}

                                @if (session()->has('discounts'))
                                    @php
                                        $discountData = session('discounts');
                                        $coupon = session('coupon');
                                    @endphp

                                    <table class="checkout-totals">
                                        <tbody>
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>Rs{{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount <span style="color:red">{{ $coupon['code'] ?? '' }}</span>
                                                </th>
                                                <td>- Rs{{ number_format($discountData['discount'], 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Subtotal After Discount</th>
                                                <td>Rs{{ number_format($discountData['subtotal'], 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td>Free</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>VAT</th>
                                                <td>Rs{{ number_format($discountData['tax'], 2) }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th>Total</th>
                                                <td><strong>${{ number_format($discountData['total'], 2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    @php
                                        // $vat = ($subtotal * $vatPercentage) / 100;
                                        $total = $subtotal;
                                    @endphp

                                    <table class="checkout-totals">
                                        <tbody>
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>Rs{{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td>Free shipping</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>VAT</th>
                                                <td>${{ number_format($vat, 2) }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th>Total</th>
                                                <td><strong>Rs{{ number_format($total, 2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div class="mobile_fixed-btn_wrapper">
                                <div class="button-wrapper container">
                                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-checkout">PROCEED TO
                                        CHECKOUT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center pt-5 pb-5">
                            <p>No item Found In Your Cart</p>
                            <a href="{{ route('shop') }}" class="btn btn-info">Shop Now</a>
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
        $(function () {
            $(".qty-control__increase").on("click", function () {
                $(this).closest('form').submit();
            });
            $(".qty-control__reduce").on("click", function () {
                $(this).closest('form').submit();
            });
            $(".remove-cart").on("click", function () {
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
