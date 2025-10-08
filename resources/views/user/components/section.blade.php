@stack('style')
<main>
    <style>
        /* Modern CSS Reset and Variables */
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary: #f59e0b;
            --accent: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --radius: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Hero Slider */
        .hero-slider {
            position: relative;
            width: 100%;
            height: 80vh;
            min-height: 600px;
            overflow: hidden;
            margin-bottom: 4rem;
        }

        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .hero-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: brightness(0.7);
            display: block;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            max-width: 600px;
            color: var(--white);
            z-index: 10;
        }

        .hero-badge {
            display: inline-block;
            background: var(--secondary);
            color: var(--dark);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            color: var(--white);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
            color: var(--white);
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary);
            color: var(--white);
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            box-shadow: var(--shadow-lg);
        }

        .hero-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        /* Section Headings */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .section-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Simple Category Grid - NO SLIDER */
        .category-section {
            margin-bottom: 4rem;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1.5rem;
        }

        .category-card {
            background: var(--white);
            padding: 1.5rem 1rem;
            border-radius: var(--radius);
            text-align: center;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-light);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .category-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            background: var(--light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            padding: 15px;
            overflow: hidden;
        }

        .category-card:hover .category-icon {
            background: var(--primary);
            transform: scale(1.1);
        }

        .category-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .category-name {
            color: var(--dark);
            font-weight: 600;
            font-size: 0.9rem;
            text-align: center;
            line-height: 1.3;
        }

        /* Products Section */
        .products-section {
            margin-bottom: 4rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        /* Product Card */
        .product-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--accent);
            color: var(--white);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 2;
        }

        .product-image {
            position: relative;
            height: 250px;
            overflow: hidden;
            background: var(--light);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 250px);
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            flex-grow: 1;
        }

        .product-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s;
        }

        .product-title a:hover {
            color: var(--primary);
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .current-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .original-price {
            font-size: 1rem;
            color: var(--gray);
            text-decoration: line-through;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--light);
            color: var(--dark);
            border: 1px solid var(--gray-light);
        }

        .btn-secondary:hover {
            background: var(--gray-light);
            transform: translateY(-2px);
        }

        /* Deals Banner */
        .deals-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 4rem 2rem;
            border-radius: var(--radius-lg);
            margin-bottom: 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .deals-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.1"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .banner-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--white);
        }

        .banner-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            color: var(--white);
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .countdown-item {
            background: rgba(255,255,255,0.2);
            padding: 1.5rem 1rem;
            border-radius: var(--radius);
            min-width: 100px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .countdown-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
            font-family: 'Courier New', monospace;
            color: var(--white);
        }

        .countdown-label {
            font-size: 1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
            color: var(--white);
        }

        .timer-running {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Footer Space */
        .footer-space {
            height: 100px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .hero-slider {
                height: 70vh;
                min-height: 500px;
            }
            
            .hero-title {
                font-size: 3rem;
            }
            
            .category-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }
            
            .banner-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-slider {
                height: 60vh;
                min-height: 400px;
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-content {
                left: 5%;
                max-width: 90%;
                text-align: center;
                padding: 0 20px;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .category-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }
            
            .category-icon {
                width: 70px;
                height: 70px;
            }
            
            .category-name {
                font-size: 0.85rem;
            }
            
            .banner-title {
                font-size: 2rem;
            }
            
            .banner-subtitle {
                font-size: 1.1rem;
            }
            
            .countdown {
                gap: 1rem;
            }
            
            .countdown-item {
                min-width: 80px;
                padding: 1rem 0.5rem;
            }
            
            .countdown-number {
                font-size: 2rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .product-image {
                height: 200px;
            }
            
            .product-info {
                padding: 1rem;
            }
            
            .product-actions {
                flex-direction: column;
                gap: 8px;
            }
            
            .btn {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .category-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .hero-slider {
                height: 50vh;
                min-height: 300px;
            }
            
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .hero-btn {
                padding: 12px 25px;
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .section-subtitle {
                font-size: 1rem;
            }
            
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.8rem;
            }
            
            .category-card {
                padding: 1rem 0.5rem;
            }
            
            .category-icon {
                width: 60px;
                height: 60px;
                padding: 10px;
            }
            
            .category-name {
                font-size: 0.8rem;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .countdown {
                gap: 0.5rem;
                flex-wrap: wrap;
            }
            
            .countdown-item {
                min-width: 70px;
                padding: 0.75rem 0.5rem;
            }
            
            .countdown-number {
                font-size: 1.5rem;
            }
            
            .countdown-label {
                font-size: 0.875rem;
            }
            
            .deals-banner {
                padding: 2rem 1rem;
            }
            
            .banner-title {
                font-size: 1.8rem;
            }
            
            .banner-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 360px) {
            .hero-title {
                font-size: 1.6rem;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }
        }
    </style>

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