@extends('user.components.master')

@section('content')
    @include('user.components.navbar')

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <div class="checkout-steps">
                <a href={{ route('cart') }} class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href={{ route('checkout') }} class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>
            <form name="checkout-form" action="{{ route('place.an.order') }}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                        @if ($address)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="my-account_address-list">
                                        <div class="my-account_address-list-item">
                                            <div class="my-account_address-item_detail">
                                                <p>{{ $address->name }}</p>
                                                <p>{{ $address->address }}</p>
                                                <p>{{ $address->city }}, {{ $address->state }}</p>
                                                <br>
                                                <p>{{ $address->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" required=""
                                            value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" required=""
                                            value="{{ old('phone') }}">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="state" required=""
                                            value="{{ old('state') }}">
                                        <label for="state">State *</label>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" required=""
                                            value="{{ old('city') }}">
                                        <label for="city">Town / City *</label>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address" required=""
                                            value="{{ old('address') }}">
                                        <label for="address">Address *</label>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th align="right">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cart = session('cart', []);
                                            $subtotal = 0;
                                        @endphp
                                        @foreach ($cart as $item)
                                            @php
                                                $itemTotal = $item['price'] * $item['quantity'];
                                                $subtotal += $itemTotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $item['name'] }} x {{ $item['quantity'] }}</td>
                                                <td align="right">${{ number_format($itemTotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @php
                                    $taxRate = 0.15; // 15% VAT
                                    $tax = $subtotal * $taxRate;
                                    $total = $subtotal + $tax;
                                @endphp

                                <table class="checkout-totals">
                                    @if (session()->has('discounts'))
                                        @php
                                            $discountData = session('discounts');
                                            $coupon = session('coupon');
                                        @endphp

                                        <table class="checkout-totals">
                                            <tbody>
                                                <tr>
                                                    <th>Subtotal</th>
                                                    <td>${{ number_format($subtotal, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Discount <span
                                                            style="color:red">{{ $coupon['code'] ?? '' }}</span></th>
                                                    <td>- ${{ number_format($discountData['discount'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Subtotal After Discount</th>
                                                    <td>${{ number_format($discountData['subtotal'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Shipping</th>
                                                    <td>Free</td>
                                                </tr>
                                                <tr>
                                                    <th>VAT</th>
                                                    <td>${{ number_format($discountData['tax'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td><strong>${{ number_format($discountData['total'], 2) }}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <tbody>
                                            <tr>
                                                <th>SUBTOTAL</th>
                                                <td align="right">${{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>SHIPPING</th>
                                                <td align="right">Free shipping</td>
                                            </tr>
                                            <tr>
                                                <th>VAT</th>
                                                <td align="right">${{ number_format($tax, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>TOTAL</th>
                                                <td align="right">${{ number_format($total, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                        id="mode1" value="card">
                                    <label class="form-check-label" for="checkout_payment_method_2">
                                        Debit or Credit Card

                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                        id="mode2" value="paypal">
                                    <label class="form-check-label" for="checkout_payment_method_4">
                                        Paypal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                        id="mode3"value="Cash_On_delivery">
                                    <label class="form-check-label" for="checkout_payment_method_3">
                                        Cash on delivery

                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience
                                    throughout this
                                    website, and for other purposes described in our <a href="#"
                                        target="_blank">privacy
                                        policy</a>.
                                </div>
                            </div>

                            <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>

                </div>
            </form>
        </section>
    </main>
    @include('user.components.footer')
@endsection
