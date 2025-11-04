@extends('user.components.master')

@section('content')
    @include('user.components.navbar')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}" type="text/css" />
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shopping Cart</h2>

            <!-- Checkout Steps -->
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

                    <div class="cart-content-wrapper">
                        <!-- Cart Items -->
                        <div class="cart-items-section">
                            <div class="cart-header">
                                <h3>Your Items ({{ count($items) }})</h3>
                            </div>

                            <div class="cart-items-list">
                                @foreach ($items as $item)
                                    @php
                                        $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                                        $price = isset($item['price']) ? (float) $item['price'] : 0;
                                        $itemSubtotal = $price * $quantity;
                                        $subtotal += $itemSubtotal;
                                    @endphp

                                    <div class="cart-item">
                                        <div class="cart-item__image">
                                            <img loading="lazy"
                                                src="{{ asset('uploads/product/' . ($item['image'] ?? 'default.png')) }}"
                                                alt="{{ $item['name'] ?? 'Product' }}" />
                                        </div>

                                        <div class="cart-item__details">
                                            <h4 class="cart-item__name">{{ $item['name'] ?? 'No Name' }}</h4>

                                            {{-- ✅ Show selected size if exists --}}
                                            @if (!empty($item['size']) && $item['size'] !== 'default')
                                                <small class="text-muted d-block mb-1">
                                                    Size: <strong>{{ ucfirst($item['size']) }}</strong>
                                                </small>
                                            @endif

                                            <div class="cart-item__price-mobile">
                                                Rs{{ number_format($price, 2) }}
                                            </div>

                                        </div>

                                        <div class="cart-item__price">
                                            <span class="price-amount">Rs{{ number_format($price, 2) }}</span>
                                        </div>

                                        <div class="cart-item__quantity">
                                            <div class="quantity-control">
                                                <form method="POST" action="{{ route('cart.qty.decrease', $item['id']) }}"
                                                    class="quantity-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="quantity-btn decrease-btn">-</button>
                                                </form>

                                                <div class="quantity-display">
                                                    <span class="quantity-value">{{ $quantity }}</span>
                                                    <span class="quantity-unit">kg</span>
                                                </div>

                                                <form method="POST" action="{{ route('cart.qty.increase', $item['id']) }}"
                                                    class="quantity-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="quantity-btn increase-btn">+</button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="cart-item__subtotal">
                                            <span class="subtotal-amount">Rs{{ number_format($itemSubtotal, 2) }}</span>
                                        </div>

                                        <div class="cart-item__actions">
                                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}"
                                                class="remove-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-btn" title="Remove item">
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="currentColor">
                                                        <path
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Cart Actions -->
                            <div class="cart-actions">
                                <div class="coupon-section">
                                    @if (!session()->has('coupon'))
                                        <form action="{{ route('apply.coupon.code') }}" method="POST" class="coupon-form">
                                            @csrf
                                            <div class="coupon-input-group">
                                                <input class="form-control coupon-input" type="text" name="coupon_code"
                                                    placeholder="Enter coupon code" required>
                                                <button type="submit" class="btn coupon-apply-btn">APPLY COUPON</button>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('remove_coupon_code') }}" method="POST"
                                            class="coupon-form">
                                            @method('DELETE')
                                            @csrf
                                            <div class="coupon-input-group">
                                                <input class="form-control coupon-input applied" type="text"
                                                    value="{{ session('coupon')['code'] . ' Applied!' }}" readonly>
                                                <button type="submit" class="btn coupon-remove-btn">REMOVE</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>

                                <form method="POST" action="{{ route('cart.empty') }}" class="clear-cart-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn clear-cart-btn" type="submit">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                            style="margin-right: 8px;">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                        CLEAR CART
                                    </button>
                                </form>
                            </div>

                            <!-- Messages -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"
                                        style="margin-right: 8px;">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-error">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"
                                        style="margin-right: 8px;">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>

                        <!-- Order Summary -->
                        <!-- Order Summary -->
                        <div class="order-summary-section">
                            <div class="order-summary-card">
                                <h3 class="summary-title">Order Summary</h3>

                                @if (Session::has('checkout'))
                                    @php
                                        $checkout = Session::get('checkout');
                                        $coupon = Session::get('coupon');
                                    @endphp

                                    <div class="summary-details">
                                        <div class="summary-row">
                                            <span class="summary-label">Subtotal</span>
                                            <span
                                                class="summary-value">Rs{{ number_format($checkout['subtotal'], 2) }}</span>
                                        </div>

                                        @if ($checkout['discount'] > 0)
                                            <div class="summary-row discount">
                                                <span class="summary-label">
                                                    Discount
                                                    <span class="coupon-code">{{ $coupon['code'] ?? '' }}</span>
                                                </span>
                                                <span class="summary-value">-
                                                    Rs{{ number_format($checkout['discount'], 2) }}</span>
                                            </div>
                                        @endif

                                        <div class="summary-row">
                                            <span class="summary-label">Shipping</span>
                                            <span class="summary-value">
                                                {{ $checkout['shipping_message'] }} -
                                                Rs{{ number_format($checkout['shipping'], 2) }}
                                            </span>
                                        </div>
                                        <div class="summary-row total">
                                            <span class="summary-label">Total Amount</span>
                                            <span
                                                class="summary-value total-amount">Rs{{ number_format($checkout['total'], 2) }}</span>
                                        </div>

                                    </div>
                                @else
                                    @php
                                        $total = $subtotal;
                                    @endphp
                                    <div class="summary-details">
                                        <div class="summary-row">
                                            <span class="summary-label">Subtotal</span>
                                            <span class="summary-value">Rs{{ number_format($total, 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Shipping</span>
                                            <span class="summary-value">Free</span>
                                        </div>
                                        <div class="summary-row total">
                                            <span class="summary-label">Total Amount</span>
                                            <span
                                                class="summary-value total-amount">Rs{{ number_format($total, 2) }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="checkout-action">
                                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-checkout">
                                        PROCEED TO CHECKOUT
                                    </a>
                                    <a href="{{ route('shop') }}" class="btn btn-outline continue-shopping">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty Cart State -->
                    <div class="empty-cart">
                        <div class="empty-cart__icon">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                </path>
                            </svg>
                        </div>
                        <h3 class="empty-cart__title">Your cart is empty</h3>
                        <p class="empty-cart__message">Looks like you haven't added any items to your cart yet.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary empty-cart__btn">
                            Start Shopping
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                style="margin-left: 8px;">
                                <path fill-rule="evenodd"
                                    d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('user.components.footer')
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity button handlers
            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.closest('form').submit();
                });
            });

            // Remove button handlers
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        this.closest('form').submit();
                    }
                });
            });

            // Clear cart confirmation
            document.querySelector('.clear-cart-btn')?.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to clear your entire cart?')) {
                    this.closest('form').submit();
                }
            });

            // Smooth animations
            const cartItems = document.querySelectorAll('.cart-item');
            cartItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    item.style.transition = 'all 0.4s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endpush
