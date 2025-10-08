@extends('user.components.master')

@section('content')
    @include('user.components.navbar')
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
                                            <div class="cart-item__price-mobile">
                                                Rs{{ number_format($price, 2) }}
                                            </div>
                                        </div>

                                        <div class="cart-item__price">
                                            <span class="price-amount">Rs{{ number_format($price, 2) }}</span>
                                        </div>

                                        <div class="cart-item__quantity">
                                            <div class="quantity-control">
                                                <form method="POST" action="{{ route('cart.qty.decrease', $item['id']) }}" class="quantity-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="quantity-btn decrease-btn">-</button>
                                                </form>

                                                <div class="quantity-display">
                                                    <span class="quantity-value">{{ $quantity }}</span>
                                                    <span class="quantity-unit">kg</span>
                                                </div>

                                                <form method="POST" action="{{ route('cart.qty.increase', $item['id']) }}" class="quantity-form">
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
                                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}" class="remove-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-btn" title="Remove item">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
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
                                        <form action="{{ route('remove_coupon_code') }}" method="POST" class="coupon-form">
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
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right: 8px;">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                        CLEAR CART
                                    </button>
                                </form>
                            </div>

                            <!-- Messages -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="margin-right: 8px;">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-error">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="margin-right: 8px;">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
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
                    <span class="summary-value">Rs{{ number_format($checkout['subtotal'], 2) }}</span>
                </div>

                @if ($checkout['discount'] > 0)
                    <div class="summary-row discount">
                        <span class="summary-label">
                            Discount
                            <span class="coupon-code">{{ $coupon['code'] ?? '' }}</span>
                        </span>
                        <span class="summary-value">- Rs{{ number_format($checkout['discount'], 2) }}</span>
                    </div>
                @endif

                <div class="summary-row">
    <span class="summary-label">Shipping</span>
    <span class="summary-value">
        {{ $checkout['shipping_message'] }} - Rs{{ number_format($checkout['shipping'], 2) }}
    </span>
</div>
<div class="summary-row total">
    <span class="summary-label">Total Amount</span>
    <span class="summary-value total-amount">Rs{{ number_format($checkout['total'], 2) }}</span>
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
                    <span class="summary-value total-amount">Rs{{ number_format($total, 2) }}</span>
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
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                            </svg>
                        </div>
                        <h3 class="empty-cart__title">Your cart is empty</h3>
                        <p class="empty-cart__message">Looks like you haven't added any items to your cart yet.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary empty-cart__btn">
                            Start Shopping
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-left: 8px;">
                                <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" clip-rule="evenodd"/>
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
<style>
    /* Base Styles */
    .shop-checkout {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 2rem;
        text-align: center;
    }

    /* Checkout Steps */
    .checkout-steps {
        display: flex;
        justify-content: center;
        margin-bottom: 3rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 1.5rem;
    }

    .checkout-steps__item {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #718096;
        padding: 1rem 2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin: 0 0.5rem;
    }

    .checkout-steps__item.active {
        background: #f7fafc;
        color: #2d3748;
    }

    .checkout-steps__item-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: #e2e8f0;
        color: #718096;
        border-radius: 50%;
        font-weight: 600;
        margin-right: 12px;
        transition: all 0.3s ease;
    }

    .checkout-steps__item.active .checkout-steps__item-number {
        background: #4299e1;
        color: white;
    }

    .checkout-steps__item-title span {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .checkout-steps__item-title em {
        font-style: normal;
        font-size: 0.8rem;
        color: #a0aec0;
    }

    /* Cart Layout */
    .cart-content-wrapper {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
        align-items: start;
    }

    /* Cart Items Section */
    .cart-items-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .cart-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .cart-header h3 {
        margin: 0;
        color: #2d3748;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .cart-items-list {
        padding: 0;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 100px 1fr auto auto auto;
        gap: 1rem;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }

    .cart-item:hover {
        background: #f8fafc;
    }

    .cart-item__image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .cart-item__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item__details {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .cart-item__name {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
        line-height: 1.4;
    }

    .cart-item__price-mobile {
        display: none;
        font-weight: 600;
        color: #4299e1;
        margin-top: 0.25rem;
    }

    .cart-item__price .price-amount {
        font-weight: 600;
        color: #2d3748;
        font-size: 1rem;
    }

    /* Quantity Control */
    .quantity-control {
        display: flex;
        align-items: center;
        background: #f7fafc;
        border-radius: 8px;
        padding: 4px;
        border: 1px solid #e2e8f0;
    }

    .quantity-form {
        margin: 0;
    }

    .quantity-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border: none;
        background: white;
        border-radius: 6px;
        color: #4a5568;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .quantity-btn:hover {
        background: #4299e1;
        color: white;
        transform: translateY(-1px);
    }

    .quantity-display {
        display: flex;
        align-items: center;
        padding: 0 12px;
        min-width: 60px;
        justify-content: center;
        font-weight: 600;
        color: #2d3748;
    }

    .quantity-value {
        margin-right: 4px;
    }

    .quantity-unit {
        font-size: 0.8rem;
        color: #718096;
    }

    .cart-item__subtotal .subtotal-amount {
        font-weight: 700;
        color: #2d3748;
        font-size: 1.1rem;
    }

    /* Remove Button */
    .remove-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: none;
        background: #fed7d7;
        color: #c53030;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .remove-btn:hover {
        background: #feb2b2;
        transform: scale(1.1);
    }

    /* Cart Actions */
    .cart-actions {
        padding: 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .coupon-section {
        flex: 1;
        min-width: 300px;
    }

    .coupon-input-group {
        display: flex;
        gap: 0.5rem;
    }

    .coupon-input {
        flex: 1;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .coupon-input.applied {
        background: #f0fff4;
        border-color: #68d391;
        color: #276749;
    }

    .coupon-apply-btn, .coupon-remove-btn {
        white-space: nowrap;
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
    }

    .coupon-apply-btn {
        background: #4299e1;
        color: white;
        border: none;
    }

    .coupon-remove-btn {
        background: #fed7d7;
        color: #c53030;
        border: none;
    }

    .clear-cart-btn {
        background: white;
        color: #718096;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .clear-cart-btn:hover {
        background: #fed7d7;
        color: #c53030;
        border-color: #fed7d7;
    }

    /* Alerts */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin: 1rem 1.5rem;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .alert-success {
        background: #f0fff4;
        color: #276749;
        border: 1px solid #c6f6d5;
    }

    .alert-error {
        background: #fed7d7;
        color: #c53030;
        border: 1px solid #feb2b2;
    }

    /* Order Summary */
    .order-summary-section {
        position: sticky;
        top: 2rem;
    }

    .order-summary-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .summary-title {
        padding: 1.5rem;
        margin: 0;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
    }

    .summary-details {
        padding: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-row.discount {
        color: #38a169;
    }

    .summary-row.total {
        border-top: 2px solid #e2e8f0;
        margin-top: 0.5rem;
        padding-top: 1rem;
    }

    .summary-label {
        color: #718096;
        font-weight: 500;
    }

    .summary-value {
        font-weight: 600;
        color: #2d3748;
    }

    .summary-value.free {
        color: #38a169;
    }

    .summary-value.total-amount {
        font-size: 1.25rem;
        color: #4299e1;
    }

    .coupon-code {
        background: #e6fffa;
        color: #234e52;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.8rem;
        margin-left: 4px;
    }

    /* Checkout Action */
    .checkout-action {
        padding: 1.5rem;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .btn-checkout {
        width: 100%;
        background: #4299e1;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        background: #3182ce;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
    }

    .continue-shopping {
        width: 100%;
        border: 1px solid #e2e8f0;
        color: #718096;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .continue-shopping:hover {
        background: #f7fafc;
        color: #4a5568;
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .empty-cart__icon {
        color: #cbd5e0;
        margin-bottom: 1.5rem;
    }

    .empty-cart__title {
        font-size: 1.5rem;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .empty-cart__message {
        color: #718096;
        margin-bottom: 2rem;
    }

    .empty-cart__btn {
        padding: 0.75rem 2rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .cart-content-wrapper {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .order-summary-section {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .shop-checkout {
            padding: 0 15px;
        }

        .checkout-steps {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .checkout-steps__item {
            margin: 0;
            padding: 1rem;
        }

        .cart-item {
            grid-template-columns: 80px 1fr auto;
            grid-template-areas:
                "image details actions"
                "image quantity subtotal"
                "image price price";
            gap: 0.75rem;
            padding: 1rem;
            position: relative;
        }

        .cart-item__image {
            grid-area: image;
            width: 70px;
            height: 70px;
        }

        .cart-item__details {
            grid-area: details;
        }

        .cart-item__price {
            grid-area: price;
            display: none;
        }

        .cart-item__price-mobile {
            display: block;
        }

        .cart-item__quantity {
            grid-area: quantity;
        }

        .cart-item__subtotal {
            grid-area: subtotal;
            text-align: right;
        }

        .cart-item__actions {
            grid-area: actions;
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .quantity-control {
            width: fit-content;
        }

        .cart-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .coupon-section {
            min-width: auto;
        }

        .coupon-input-group {
            flex-direction: column;
        }

        .empty-cart {
            padding: 3rem 1rem;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.5rem;
        }

        .cart-item {
            grid-template-columns: 60px 1fr auto;
            grid-template-areas:
                "image details actions"
                "image quantity quantity"
                "image price subtotal";
            gap: 0.5rem;
        }

        .cart-item__image {
            width: 60px;
            height: 60px;
        }

        .cart-item__name {
            font-size: 0.9rem;
        }

        .quantity-control {
            justify-content: space-between;
            width: 100%;
        }

        .quantity-display {
            min-width: auto;
            padding: 0 8px;
        }
    }
</style>
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
