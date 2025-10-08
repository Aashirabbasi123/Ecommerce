@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="wishlist-container container">
            <h2 class="page-title">My Wishlist</h2>

            <!-- Checkout Steps -->
            <div class="checkout-steps">
                <a href="{{ route('cart') }}" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="{{ route('wishlist') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Wishlist</span>
                        <em>Save Your Favorite Items</em>
                    </span>
                </a>
                <a href="{{ route('checkout') }}" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Checkout</span>
                        <em>Complete Your Purchase</em>
                    </span>
                </a>
            </div>

            <div class="wishlist-content">
                @if (session()->has('wishlist') && count(session('wishlist')) > 0)
                    <div class="wishlist-header">
                        <div class="wishlist-info">
                            <h3>Saved Items ({{ count($items) }})</h3>
                            <p>Your favorite products are saved here for later</p>
                        </div>
                        <form method="POST" action="{{ route('wishlist.empty') }}" class="clear-wishlist-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-clear-wishlist">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                Clear All
                            </button>
                        </form>
                    </div>

                    <div class="wishlist-items-grid">
                        @foreach ($items as $item)
                            <div class="wishlist-item-card">
                                <div class="wishlist-item__image">
                                    <img loading="lazy"
                                         src="{{ asset('uploads/product/' . $item['image']) }}"
                                         alt="{{ $item['name'] }}"
                                         class="product-image" />
                                    <div class="wishlist-item__badge">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="wishlist-item__content">
                                    <h4 class="wishlist-item__name">{{ $item['name'] }}</h4>
                                    <div class="wishlist-item__price">Rs{{ number_format($item['price'], 2) }}</div>
                                    <div class="wishlist-item__quantity">{{ $item['quantity'] }} kg</div>

                                    <div class="wishlist-item__actions">
                                        <form method="POST" action="{{ route('wishlist.move.cart', ['id' => $item['id']]) }}" class="action-form">
                                            @csrf
                                            <button type="submit" class="btn-move-cart">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('wishlist.remove', $item['id']) }}" class="action-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-remove-item" title="Remove from wishlist">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="wishlist-footer">
                        <div class="wishlist-actions">
                            <a href="{{ route('shop') }}" class="btn-continue-shopping">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                                </svg>
                                Continue Shopping
                            </a>
                            <a href="{{ route('cart') }}" class="btn-view-cart">
                                View Cart
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                                    <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Empty Wishlist State -->
                    <div class="empty-wishlist">
                        <div class="empty-wishlist__icon">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </div>
                        <h3 class="empty-wishlist__title">Your wishlist is empty</h3>
                        <p class="empty-wishlist__message">Save your favorite items here to purchase them later</p>
                        <div class="empty-wishlist__actions">
                            <a href="{{ route('shop') }}" class="btn btn-primary">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M6 1a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V1z"/>
                                    <path fill-rule="evenodd" d="M11.5 3H14a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-.5l-.5 8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1l-.5-8H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1h1a1 1 0 0 1 1 1zM4.118 5L4.5 13h7L11.882 5H4.118z"/>
                                </svg>
                                Start Shopping
                            </a>
                        </div>
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
    .wishlist-container {
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
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .checkout-steps__item {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #718096;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        min-width: 200px;
        justify-content: center;
    }

    .checkout-steps__item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
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
        background: rgba(255, 255, 255, 0.2);
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
        opacity: 0.8;
    }

    /* Wishlist Header */
    .wishlist-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .wishlist-info h3 {
        margin: 0 0 0.5rem 0;
        color: #2d3748;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .wishlist-info p {
        margin: 0;
        color: #718096;
        font-size: 0.9rem;
    }

    .btn-clear-wishlist {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.75rem 1.5rem;
        background: #fed7d7;
        color: #c53030;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-clear-wishlist:hover {
        background: #feb2b2;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(254, 178, 178, 0.3);
    }

    /* Wishlist Items Grid */
    .wishlist-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .wishlist-item-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .wishlist-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .wishlist-item__image {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: #f7fafc;
    }

    .wishlist-item__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .wishlist-item-card:hover .wishlist-item__image img {
        transform: scale(1.05);
    }

    .wishlist-item__badge {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
    }

    .wishlist-item__content {
        padding: 1.5rem;
    }

    .wishlist-item__name {
        margin: 0 0 0.75rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        line-height: 1.4;
    }

    .wishlist-item__price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #4299e1;
        margin-bottom: 0.5rem;
    }

    .wishlist-item__quantity {
        color: #718096;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        padding: 0.25rem 0.75rem;
        background: #f7fafc;
        border-radius: 20px;
        display: inline-block;
    }

    .wishlist-item__actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .action-form {
        margin: 0;
    }

    .btn-move-cart {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-move-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
    }

    .btn-remove-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        background: #fed7d7;
        color: #c53030;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-remove-item:hover {
        background: #feb2b2;
        transform: scale(1.1);
    }

    /* Wishlist Footer */
    .wishlist-footer {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 2rem;
        text-align: center;
    }

    .wishlist-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-continue-shopping {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.75rem 1.5rem;
        background: white;
        color: #718096;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-continue-shopping:hover {
        background: #f7fafc;
        color: #4a5568;
        border-color: #cbd5e0;
    }

    .btn-view-cart {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.75rem 1.5rem;
        background: #4299e1;
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-view-cart:hover {
        background: #3182ce;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
    }

    /* Empty Wishlist State */
    .empty-wishlist {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .empty-wishlist__icon {
        color: #e2e8f0;
        margin-bottom: 1.5rem;
    }

    .empty-wishlist__title {
        font-size: 1.5rem;
        color: #4a5568;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .empty-wishlist__message {
        color: #718096;
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    .empty-wishlist__actions .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-decoration: none;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .wishlist-items-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .wishlist-container {
            padding: 0 15px;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .checkout-steps {
            flex-direction: column;
            align-items: stretch;
        }

        .checkout-steps__item {
            min-width: auto;
            justify-content: flex-start;
        }

        .wishlist-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .wishlist-items-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .wishlist-item__content {
            padding: 1rem;
        }

        .wishlist-item__actions {
            flex-direction: column;
        }

        .btn-move-cart {
            width: 100%;
        }

        .wishlist-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .empty-wishlist {
            padding: 3rem 1rem;
        }
    }

    @media (max-width: 480px) {
        .wishlist-items-grid {
            grid-template-columns: 1fr;
        }

        .wishlist-item__image {
            height: 180px;
        }

        .checkout-steps__item {
            padding: 0.75rem 1rem;
        }

        .checkout-steps__item-title span {
            font-size: 0.85rem;
        }

        .checkout-steps__item-title em {
            font-size: 0.75rem;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .wishlist-item-card {
        animation: fadeInUp 0.5s ease forwards;
    }

    .wishlist-item-card:nth-child(1) { animation-delay: 0.1s; }
    .wishlist-item-card:nth-child(2) { animation-delay: 0.2s; }
    .wishlist-item-card:nth-child(3) { animation-delay: 0.3s; }
    .wishlist-item-card:nth-child(4) { animation-delay: 0.4s; }
    .wishlist-item-card:nth-child(5) { animation-delay: 0.5s; }
    .wishlist-item-card:nth-child(6) { animation-delay: 0.6s; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Remove item confirmation
        document.querySelectorAll('.btn-remove-item').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const itemName = this.closest('.wishlist-item-card').querySelector('.wishlist-item__name').textContent;

                if (confirm(`Are you sure you want to remove "${itemName}" from your wishlist?`)) {
                    this.closest('form').submit();
                }
            });
        });

        // Clear wishlist confirmation
        document.querySelector('.btn-clear-wishlist')?.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear your entire wishlist? This action cannot be undone.')) {
                this.closest('form').submit();
            }
        });

        // Add smooth animations
        const wishlistItems = document.querySelectorAll('.wishlist-item-card');
        wishlistItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';

            setTimeout(() => {
                item.style.transition = 'all 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Add to cart success feedback
        document.querySelectorAll('.btn-move-cart').forEach(button => {
            button.addEventListener('click', function(e) {
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                    </svg>
                    Added!
                `;

                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });
    });
</script>
@endpush
