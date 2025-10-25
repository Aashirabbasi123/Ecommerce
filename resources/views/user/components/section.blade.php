@stack('style')
<main>
  <link rel="stylesheet" href="{{ asset('css/section.css') }}" type="text/css" />

    <!-- Hero Slider -->
    <section class="hero-slider">
        <div class="swiper-container hero-main-slider">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide">
                        <img class="hero-bg" src="{{ asset('uploads/slides/' . $slide->image) }}" alt="{{ $slide->title }}" loading="lazy">
                        <div class="hero-content">
                            <span class="hero-badge">New Arrivals</span>
                            <h1 class="hero-title">{{ $slide->title }}</h1>
                            <p class="hero-subtitle">{{ $slide->subtitle }}</p>
                            <a href="{{ $slide->link }}" class="hero-btn">
                                Shop Now
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Simple Category Grid - NO SLIDER -->
    <section class="container category-section">
        <div class="section-header">
            <h2 class="section-title">Categories</h2>
            <p class="section-subtitle">Discover our wide range of products across different categories</p>
        </div>
        <div class="category-grid">
            @foreach ($categories as $category)
                <a href="{{ route('shop', ['categories' => $category->id]) }}" class="category-card">
                    <div class="category-icon">
                        <img src="{{ asset('uploads/category/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy">
                    </div>
                    <div class="category-name">{{ $category->name }}</div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Deals Banner -->
    <section class="container">
        <div class="deals-banner">
            <div class="banner-content">
                <h2 class="banner-title">🔥 Deals of the Day</h2>
                <p class="banner-subtitle">Hurry up! These amazing offers are ending soon. Don't miss your chance!</p>
                <div class="countdown">
                    <div class="countdown-item timer-running">
                        <span class="countdown-number" id="days">00</span>
                        <span class="countdown-label">Days</span>
                    </div>
                    <div class="countdown-item timer-running">
                        <span class="countdown-number" id="hours">00</span>
                        <span class="countdown-label">Hours</span>
                    </div>
                    <div class="countdown-item timer-running">
                        <span class="countdown-number" id="minutes">00</span>
                        <span class="countdown-label">Minutes</span>
                    </div>
                    <div class="countdown-item timer-running">
                        <span class="countdown-number" id="seconds">00</span>
                        <span class="countdown-label">Seconds</span>
                    </div>
                </div>
                <a href="{{ route('shop') }}" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    Shop All Deals
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="container products-section">
        <div class="section-header">
            <h2 class="section-title">Featured Products</h2>
            <p class="section-subtitle">Handpicked items just for you</p>
        </div>
        <div class="products-grid">
            @foreach ($products as $product)
                @php
                    $discount = 0;
                    if ($product->sale_price && $product->sale_price < $product->regular_price) {
                        $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                    }
                @endphp

                <div class="product-card">
                    @if ($discount > 0)
                        <div class="product-badge">-{{ $discount }}% OFF</div>
                    @endif

                    <div class="product-image">
                        <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                    </div>

                    <div class="product-info">
                        <h3 class="product-title">
                            <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="product-price">
                            @if ($product->sale_price && $product->sale_price < $product->regular_price)
                                <span class="current-price">Rs{{ number_format($product->sale_price, 2) }}</span>
                                <span class="original-price">Rs{{ number_format($product->regular_price, 2) }}</span>
                            @else
                                <span class="current-price">Rs{{ number_format($product->regular_price, 2) }}</span>
                            @endif
                        </div>

                        <div class="product-actions">
                            <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}" class="btn btn-primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                                Add to Cart
                            </a>
                            <button class="btn btn-secondary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Deals Products -->
    <section class="container products-section">
        <div class="products-grid">
            @foreach ($products->where('sale_price', '<', \DB::raw('regular_price'))->take(8) as $product)
                @php
                    $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                @endphp

                <div class="product-card">
                    <div class="product-badge">-{{ $discount }}% OFF</div>

                    <div class="product-image">
                        <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                    </div>

                    <div class="product-info">
                        <h3 class="product-title">
                            <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="product-price">
                            <span class="current-price">Rs{{ number_format($product->sale_price, 2) }}</span>
                            <span class="original-price">Rs{{ number_format($product->regular_price, 2) }}</span>
                        </div>

                        <div class="product-actions">
                            <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}" class="btn btn-primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                                Buy Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Footer Space -->
    <div class="footer-space"></div>
</main>

<!-- Add Swiper JS and CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Initialize Hero Slider Only
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Slider
        const heroSwiper = new Swiper('.hero-main-slider', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            }
        });

        // Countdown Timer
        function updateCountdown() {
            const now = new Date();
            const target = new Date();
            target.setHours(23, 59, 59, 999);

            if (now > target) {
                target.setDate(target.getDate() + 1);
            }

            const diff = target - now;

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');

            const secondsElement = document.getElementById('seconds');
            secondsElement.classList.add('timer-running');
            setTimeout(() => {
                secondsElement.classList.remove('timer-running');
            }, 500);
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Image loading handling
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.onerror = function() {
                this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRjBGMEYwIi8+CjxwYXRoIGQ9Ik04MCA2MEgxMjBWMTIwSDgwVjYwWiIgZmlsbD0iI0Q4RDhEOCIvPgo8cGF0aCBkPSJNNjAgODBIMTQwVjEwMEg2MFY4MFpNNjAgMTIwSDE0MFYxNDBINjBWMTIwWiIgZmlsbD0iI0Q4RDhEOCIvPgo8L3N2Zz4K';
            };

            if (img.complete) {
                img.style.opacity = '1';
            } else {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.3s ease';
            }
        });
    });
</script>
