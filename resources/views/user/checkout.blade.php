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

            {{-- Loader --}}
            <div id="loader-overlay">
                <div class="spinner"></div>
            </div>

            <form name="checkout-form" action="{{ route('place.an.order') }}" method="POST" id="checkout-form">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                        </div>

                        {{-- Address Check --}}
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
                            {{-- Address Form --}}
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" required
                                            value="{{ old('phone') }}">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="state" required
                                            value="{{ old('state') }}">
                                        <label for="state">State *</label>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" required value="{{ old('city') }}">
                                        <label for="city">Town / City *</label>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address" required
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

                    {{-- Checkout Totals --}}
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
                                                <td align="right">Rs{{ number_format($itemTotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @php
                                    $tax = $subtotal;
                                    $total = $subtotal;
                                @endphp

                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>SUBTOTAL</th>
                                            <td align="right">Rs{{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td align="right">Free shipping</td>
                                        </tr>
                                        <tr>
                                            <th>TOTAL</th>
                                            <td align="right">Rs{{ number_format($total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                        id="mode3" value="Cash_On_delivery" checked>
                                    <label class="form-check-label" for="mode3">
                                        Cash on delivery
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience
                                    throughout this website, and for other purposes described in our.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-checkout" id="place-order-btn">
                                <span id="btn-text">PLACE ORDER</span>
                                <span id="btn-loader" class="spinner-border spinner-border-sm ms-2"
                                    style="display:none;"></span>
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    @include('user.components.footer')

    {{-- Loader CSS & JS --}}
    <style>
        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #ddd;
            border-top: 6px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .spinner-border {
            vertical-align: middle;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', function () {
            // Screen overlay loader
            document.getElementById('loader-overlay').style.display = 'flex';

            // Button loader
            document.getElementById('btn-text').innerText = "Processing...";
            document.getElementById('btn-loader').style.display = "inline-block";

            // Button disable kar do taake dubara click na ho
            document.getElementById('place-order-btn').disabled = true;
        });
    </script>
@endsection
