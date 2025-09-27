@stack('style')
<main>
    @stack('style')
    <main>
        <style>
            /* Root and Typography */
            :root {
                --ocean-blue: #0077b6;
                --light-blue: #00c4ff;
                --dark-blue: #023e8a;
                --light-gray: #f7f9fb;
                --text-dark: #001219;
                --text-light: #f0f0f0;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: var(--light-gray);
                color: var(--text-dark);
                margin: 0;
                padding: 0;
                font-size: 16px;
                line-height: 1.5;
            }

            body,
            html {
                overflow-x: hidden !important;
            }

            /* 🛍️ Product Card */
            .product-card {
                background: #fff;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                text-align: center;
                position: relative;
                max-width: 100%;
                /* Mobile friendly width */
                margin: 1rem auto;
                /* Center on mobile */
                padding: 0 1rem;
                /* Mobile padding */
            }

            .product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            }

            /* 📸 Product Image */
            .pc__img-wrapper {
                position: relative;
                overflow: hidden;
                border-bottom: 1px solid #eee;
            }

            .pc__img {
                width: 100%;
                height: auto;
                border-radius: 12px;
                transition: transform 0.5s ease;
            }

            .product-card:hover .pc__img {
                transform: scale(1.05);
            }

            /* 🔖 Discount Badge */
            .discount-badge {
                position: absolute;
                top: 12px;
                left: 12px;
                background: var(--light-blue);
                color: #fff;
                font-size: 0.75rem;
                font-weight: bold;
                padding: 4px 10px;
                border-radius: 20px;
            }

            /* 📝 Title */
            .pc__title {
                margin: 12px 0 6px;
                font-size: 1rem;
                font-weight: 600;
                color: var(--dark-blue);
            }

            .pc__title a {
                text-decoration: none;
                color: inherit;
                transition: color 0.3s;
            }

            .pc__title a:hover {
                color: var(--ocean-blue);
            }

            /* 💲 Price */
            .product-card__price {
                font-size: 0.95rem;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 8px;
            }

            .price-old {
                text-decoration: line-through;
                color: #999;
                font-size: 0.9rem;
            }

            .price-new,
            .text-secondary {
                color: var(--ocean-blue);
                font-weight: 700;
            }

            /* HERO SLIDER */
            .mySlider {
                width: 100vw;
                max-width: 100vw;
                margin-left: calc(-50vw + 50%);
                height: 100vh;
                position: relative;
                background-color: var(--dark-blue);
                overflow: hidden !important;
            }

            /* Slide background */
            .hero-bg {
                width: 100%;
                height: 100%;
                object-fit: cover;
                filter: brightness(0.6);
                transition: filter 0.5s ease;
            }

            .swiper-slide:hover .hero-bg {
                filter: brightness(0.8);
            }

            /* Overlay for readability */
            .hero-slide-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                overflow: hidden;
                height: 100%;
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.2));
            }

            /* Hero content */
            .hero-content {
                position: absolute;
                top: 50%;
                left: 10%;
                transform: translateY(-50%);
                max-width: 600px;
                color: var(--text-light);
                z-index: 2;
                text-align: left;
                padding-right: 1rem;
            }

            .hero-tagline {
                font-size: 1rem;
                font-weight: 700;
                letter-spacing: 2px;
                margin-bottom: 0.8rem;
                text-transform: uppercase;
                color: var(--light-blue);
            }

            .hero-title {
                font-size: 3rem;
                font-weight: 800;
                margin-bottom: 0.5rem;
                line-height: 1.2;
            }

            .hero-subtitle {
                font-size: 1.25rem;
                font-weight: 400;
                margin-bottom: 1.5rem;
            }

            /* Hero Button */
            .hero-btn,
            .btn {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background: var(--light-blue);
                color: var(--text-light);
                font-weight: 600;
                border-radius: 30px;
                text-decoration: none;
                transition: all 0.3s ease;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                cursor: pointer;
                border: none;
            }

            .hero-btn:hover,
            .btn:hover {
                background: var(--ocean-blue);
                transform: translateY(-2px);
            }

            /* Section Headings */
            .section-title {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 2rem;
                color: var(--dark-blue);
            }

            /* Category Banner */
            .category-banner__item {
                position: relative;
                overflow: hidden;
                border-radius: 12px;
            }

            .category-banner__item img {
                width: 100%;
                height: auto;
                object-fit: cover;
                border-radius: 12px;
                transition: transform 0.5s ease;
            }

            .category-banner__item:hover img {
                transform: scale(1.05);
            }

            .category-banner__item-content {
                position: absolute;
                bottom: 20px;
                left: 20px;
                color: #fff;
            }

            .btn-link {
                color: var(--light-blue);
                text-decoration: underline;
                font-weight: 600;
            }

            /* Responsive Adjustments */
            @media (max-width: 992px) {
                .mySlider {
                    height: 350px;
                }

                .hero-title {
                    font-size: 2.2rem;
                }

                .hero-subtitle {
                    font-size: 1rem;
                }
            }

            @media (max-width: 768px) {
                .mySlider {
                    height: 300px;

                }

                .hero-content {
                    left: 50%;
                    top: 55%;
                    transform: translate(-50%, -55%);
                    text-align: center;
                    max-width: 90%;
                    padding: 0 1rem;
                }

                .hero-title {
                    font-size: 1.8rem;
                }

                .hero-subtitle {
                    font-size: 1rem;
                }

                .hero-tagline {
                    font-size: 0.85rem;
                }
            }

            @media (max-width: 480px) {
                body {
                    padding-left: 1rem;
                    padding-right: 1rem;
                    font-size: 14px;
                    line-height: 1.4;

                }

                .mySlider {
                    height: 250px;
                }

                .hero-content {
                    left: 50%;
                    top: 55%;
                    transform: translate(-50%, -55%);
                    text-align: center;
                    max-width: 90%;
                    padding: 0 1rem;
                }

                .hero-title {
                    font-size: 1.3rem;
                    line-height: 1.3;
                }

                .hero-subtitle {
                    font-size: 1rem;
                }

                .hero-btn {
                    display: block;
                    margin: 1rem auto 0 auto;
                    font-size: 1rem;
                    padding: 0.85rem 1.5rem;
                    width: 90%;
                    max-width: 300px;
                    box-sizing: border-box;
                }

                .product-card {
                    padding: 0;
                    margin: 1rem 0;

                }

                .pc__title {
                    font-size: 0.85rem;
                    padding: 0 0.5rem;
                }

                .product-card__price {
                    font-size: 0.8rem;
                }
            }
        </style>
        <!-- HERO SLIDER -->
        <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow mySlider" data-settings='{
        "autoplay": { "delay": 5000 },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
        }'>
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide position-relative">
                        <img class="hero-bg" src="{{ asset('uploads/slides/' . $slide->image) }}" alt="{{ $slide->title }}">

                        <div class="hero-content">
                            <div class="hero-tagline">New Arrivals</div>
                            <div class="hero-title">{{ $slide->title }}</div>
                            <div class="hero-subtitle">{{ $slide->subtitle }}</div>
                            <a href="{{ $slide->link }}" class="btn">Shop Now</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="container">
                <div
                    class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
                </div>
            </div>
        </section>

        <!-- CATEGORY CAROUSEL -->
        <section class="category-carousel container mt-5">
            <h2 class="section-title text-center">You Might Like</h2>
            <div class="position-relative">
                <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": { "delay": 5000 },
            "slidesPerView": 8,
            "slidesPerGroup": 1,
            "loop": true,
            "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
            },
            "breakpoints": {
                "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 15 },
                "768": { "slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 30 },
                "992": { "slidesPerView": 6, "slidesPerGroup": 1, "spaceBetween": 45 },
                "1200": { "slidesPerView": 8, "slidesPerGroup": 1, "spaceBetween": 60 }
            }
        }'>
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            <div class="swiper-slide text-center category-banner__item"
                                style="display: flex; flex-direction: column;">
                                <div>
                                    <img src="{{ asset('uploads/category/' . $category->image) }}"
                                        alt="{{ $category->name }}"
                                        style="width: 124px; height: 124px; object-fit: contain; display: block;">
                                </div>

                                <div>
                                    <a href="{{ route('shop', ['categories' => $category->id]) }}" class="menu-link">
                                        {{ $category->name }}
                                    </a>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </section>


        <!-- HOT DEALS -->
        <section class="hot-deals container mt-5">
            <h2 class="section-title text-center">Deals</h2>
            <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": { "delay": 5000 },
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "loop": false,
            "breakpoints": {
                "0": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 10 },
                "480": { "slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 14 },
                "768": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 24 },
                "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 30 },
                "1200": { "slidesPerView": 4, "slidesPerGroup": 1, "spaceBetween": 30 }
            }

        }'>
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
                        @php
                            $discount = 0;
                            if ($product->sale_price && $product->sale_price < $product->regular_price) {
                                $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                            }
                        @endphp

                        <div class="swiper-slide product-card product-card_style3">
                            <div class="pc__img-wrapper position-relative">
                                @if ($discount > 0)
                                    <div
                                        style="position: absolute; top: 10px; left: 10px; background-color: red; color: white; padding: 5px 8px; font-size: 13px; font-weight: bold; border-radius: 4px; z-index: 5;">
                                        -{{ $discount }}%
                                    </div>
                                @endif
                                <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                    <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="pc__img">
                                </a>
                            </div>
                            <div class="pc__info">
                                <h6 class="pc__title">
                                    <a
                                        href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                </h6>
                                <div class="product-card__price">
                                    @if ($product->sale_price && $product->sale_price < $product->regular_price)
                                        <span class="price price-old">Rs{{ number_format($product->regular_price, 2) }}</span>
                                        <span class="text-secondary">Rs{{ number_format($product->sale_price, 2) }}</span>
                                    @else
                                        <span class="text-secondary">Rs{{ number_format($product->regular_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- CATEGORY BANNER -->
        <section class="category-banner container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="category-banner__item">
                        <img src="images/Homepage.png" alt="SeaFood" />
                        <div class="category-banner__item-content">
                            <h3>SeaFood</h3>
                            <a href="#" class="btn-link">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-banner__item">
                        <img src="images/Homepage2.png" alt="Sea Fish" />
                        <div class="category-banner__item-content">
                            <h3>Sea Fish</h3>
                            <a href="#" class="btn-link">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURED PRODUCTS -->
        <section class="products-grid container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

            <div class="row">
                @foreach ($products as $product)
                    @php
                        $discount = 0;
                        if ($product->sale_price && $product->sale_price < $product->regular_price) {
                            $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                        }
                    @endphp

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="product-card product-card_style3 h-100">
                            <div class="pc__img-wrapper position-relative">
                                {{-- Discount Badge --}}
                                @if ($discount > 0)
                                    <div
                                        style="position: absolute; top: 10px; left: 10px; background-color: red; color: white; padding: 5px 8px; font-size: 13px; font-weight: bold; border-radius: 4px; z-index: 5;">
                                        -{{ $discount }}%
                                    </div>
                                @endif

                                <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                    <img loading="lazy" src="{{ asset('uploads/product/' . $product->image) }}" width="330"
                                        height="400" alt="{{ $product->name }}" class="pc__img img-fluid">
                                </a>
                            </div>
                            <div class="pc__info position-relative text-center">
                                <h6 class="pc__title">
                                    <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                        {{ $product->name }}
                                    </a>
                                </h6>
                                <div class="product-card__price d-flex align-items-center justify-content-center">
                                    @if ($product->sale_price && $product->sale_price < $product->regular_price)
                                        <span class="money price price-old">
                                            Rs{{ number_format($product->regular_price, 2) }}
                                        </span>
                                        <span class="money price text-secondary ms-2">
                                            Rs{{ number_format($product->sale_price, 2) }}
                                        </span>
                                    @else
                                        <span class="money price text-secondary">
                                            Rs{{ number_format($product->regular_price, 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>


        </div>
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    </main>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

</main>
<script>
    document.querySelectorAll('.js-swiper-slider').forEach(slider => {
        const settings = JSON.parse(slider.getAttribute('data-settings'));
        new Swiper(slider, settings);
    });
    var swiper = new Swiper(".swiper-container", {
        slidesPerView: 4,
        spaceBetween: 20,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 15,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
        },
    });

</script>
