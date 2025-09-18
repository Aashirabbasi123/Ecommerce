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
        }

        main {
            padding: 0 1rem;
        }

        /* Slider container */
        .mySlider {
            width: 100%;
            height: 100vh;
            position: relative;
            overflow: hidden;
            background-color: var(--dark-blue);
        }

        /* Slide background image */
        .hero-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
            transition: filter 0.5s ease;
        }

        .swiper-slide:hover .hero-bg {
            filter: brightness(0.85);
        }

        /* Hero content */
        .hero-content {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            max-width: 700px;
            color: var(--text-light);
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.8);
        }

        .hero-tagline {
            font-size: 1.125rem;
            /* 18px */
            font-weight: 700;
            letter-spacing: 3px;
            margin-bottom: 1rem;
            text-transform: uppercase;
            color: var(--light-blue);
        }

        .hero-title {
            font-size: 3.5rem;
            /* 56px */
            font-weight: 900;
            margin-bottom: 0.5rem;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.75rem;
            /* 28px */
            font-weight: 400;
            margin-bottom: 1.5rem;
        }

        /* Buttons */
        .btn {
            background: var(--light-blue);
            color: var(--text-dark);
            padding: 14px 40px;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(0, 196, 255, 0.4);
            transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
            text-transform: uppercase;
        }

        .btn:hover {
            background: var(--text-light);
            color: var(--dark-blue);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 196, 255, 0.6);
        }

        .product-card_style3 {
            background-color: var(--light-sky);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 180, 216, 0.1);
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }

        .product-card_style3:hover {
            box-shadow: 0 8px 30px rgba(0, 180, 216, 0.25);
            transform: translateY(-5px);
        }

        .pc__img-wrapper {
            overflow: hidden;
            border-bottom: 2px solid var(--aqua-blue);
        }

        .pc__img-wrapper img {
            width: 100%;
            border-radius: 20px 20px 0 0;
            transition: transform 0.3s ease;
        }

        .product-card_style3:hover .pc__img-wrapper img {
            transform: scale(1.08);
        }

        .pc__title a {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--sea-blue);
            text-decoration: none;
        }

        .product-card__price {
            font-size: 1rem;
            color: var(--coral);
            font-weight: 600;
        }

        .price-old {
            text-decoration: line-through;
            color: #999;
            margin-right: 8px;
        }

        .pc__info {
            padding: 15px 15px 10px;
            background-color: var(--foam-white);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-content {
                left: 50%;
                top: 60%;
                transform: translate(-50%, -60%);
                max-width: 90%;
                text-align: center;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1.125rem;
            }

            .hero-tagline {
                font-size: 0.875rem;
            }
        }

        .product-card_style3 {
            background: white;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
            overflow: hidden;
        }

        .product-card_style3:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .pc__img-wrapper img {
            border-radius: 15px 15px 0 0;
            transition: transform 0.3s ease;
        }

        .product-card_style3:hover .pc__img-wrapper img {
            transform: scale(1.08);
        }

        .pc__info {
            padding: 1rem 1.25rem 1.5rem;
        }

        .pc__title a {
            color: var(--dark-blue);
            font-weight: 700;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .pc__title a:hover {
            color: var(--light-blue);
        }

        .product-card__price {
            font-size: 1rem;
            color: var(--light-blue);
            font-weight: 700;
        }

        .price-old {
            color: #999;
            text-decoration: line-through;
            margin-right: 10px;
        }

        /* Category carousel styling */
        .category-carousel h2.section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 2rem;
            text-transform: uppercase;
        }

        .swiper-slide img {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .swiper-slide img:hover {
            transform: scale(1.05);
        }

        /* Category text */
        .menu-link {
            color: var(--dark-blue);
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-block;
            margin-top: 0.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .menu-link:hover {
            color: var(--light-blue);
        }

        /* Hot Deals Section */
        .hot-deals h2.section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 2rem;
        }

        .product-card_style3 {
            background: white;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
            overflow: hidden;
        }

        .product-card_style3:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .pc__img-wrapper img {
            border-radius: 15px 15px 0 0;
            transition: transform 0.3s ease;
        }

        .product-card_style3:hover .pc__img-wrapper img {
            transform: scale(1.08);
        }

        .pc__info {
            padding: 1rem 1.25rem 1.5rem;
        }

        .pc__title a {
            color: var(--dark-blue);
            font-weight: 700;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .pc__title a:hover {
            color: var(--light-blue);
        }

        .product-card__price {
            font-size: 1rem;
            color: var(--light-blue);
            font-weight: 700;
        }

        .price-old {
            color: #999;
            text-decoration: line-through;
            margin-right: 10px;
        }

        /* Featured Products Section */
        .products-grid h2.section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 2rem;
        }

        /* Category Banner */
        .category-banner__item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .category-banner__item img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .category-banner__item:hover img {
            transform: scale(1.1);
        }

        .category-banner__item-content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            text-shadow: 0 5px 20px rgba(0, 0, 0, 0.8);
        }

        .category-banner__item-content h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .category-banner__item-content .btn-link {
            font-size: 1rem;
            color: var(--light-blue);
            border-bottom: 2px solid var(--light-blue);
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
        }

        .category-banner__item-content .btn-link:hover {
            color: var(--text-light);
            border-color: var(--text-light);
        }
    </style>





    <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
      }'>
        <div class="swiper-wrapper">
            @foreach ($slides as $slide)
                <div class="swiper-slide">
                    <div class="container d-flex align-items-center justify-content-between h-100">

                        <!-- Left Side Text -->
                        <div class="slideshow-text text-start">
                            <h6
                                class="text-uppercase fs-6 fw-medium text-muted mb-2 animate animate_fade animate_btt animate_delay-3">
                                New Arrivals
                            </h6>
                            <h2 class="h1 fw-bold mb-1 animate animate_fade animate_btt animate_delay-5">
                                {{ $slide->title }}
                            </h2>
                            <h2 class="h2 fw-normal mb-3 animate animate_fade animate_btt animate_delay-5">
                                {{ $slide->subtitle }}
                            </h2>
                            <a href="{{ $slide->link }}"
                                class="btn btn-dark px-4 py-2 animate animate_fade animate_btt animate_delay-7">
                                Shop Now
                            </a>
                        </div>

                        <!-- Right Side Image -->
                        <div class="slideshow-image text-end">
                            <img src="{{ asset('uploads/slides/' . $slide->image) }}" alt="{{ $slide->title }}"
                                class="img-fluid animate animate_fade animate_btt animate_delay-9"
                                style="max-height: 500px; object-fit: contain;" />
                        </div>

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
    <div class="container mw-1620 bg-white border-radius-10">
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
        <section class="category-carousel container">
            <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

            <div class="position-relative">
                <div class="swiper-container js-swiper-slider" data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "effect": "none",
              "loop": true,
              "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "spaceBetween": 30
                },
                "992": {
                  "slidesPerView": 6,
                  "slidesPerGroup": 1,
                  "spaceBetween": 45,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 8,
                  "slidesPerGroup": 1,
                  "spaceBetween": 60,
                  "pagination": false
                }
              }
            }'>
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            <div class="swiper-slide">
                                <img loading="lazy" class="w-100 h-auto mb-3"
                                    src="{{ asset('uploads/category/' . $category->image) }}" alt="{{ $category->name }}"
                                    width="124" height="124" alt="" />
                                <div class="text-center">
                                    <a href="{{ route('shop', ['categories' => $category->id]) }}"
                                        class="menu-link fw-medium">{{ $category->name }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div
                    class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div><!-- /.products-carousel__prev -->
                <div
                    class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div><!-- /.products-carousel__next -->
            </div><!-- /.position-relative -->
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="hot-deals container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
            <div class="row">
                {{-- <div
                    class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                    <h2>Summer Sale</h2>
                    <h2 class="fw-bold">Up to 60% Off</h2>
                    <a href={{ route('shop') }} class="btn-link default-underline text-uppercase fw-medium mt-3">View
                        All</a>
                </div> --}}
                <div class="col-md-6 col-lg-8 col-xl-80per">
                    <div class="position-relative">
                        <div class="swiper-container js-swiper-slider" data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 3,
                      "spaceBetween": 24
                    },
                    "992": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    }
                  }
                }'>
                            <div class="swiper-wrapper">
                                @foreach ($products as $product)
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                                <img loading="lazy" src="{{ asset('uploads/product/' . $product->image) }}"
                                                    width="258" height="313" alt="{{ $product->name }}" class="pc__img">
                                                <img loading="lazy" src="{{ asset('uploads/product/' . $product->image) }}"
                                                    width="258" height="313" alt="{{ $product->name }}"
                                                    class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title">
                                                <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h6>
                                            <div class="product-card__price d-flex align-items-center">
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
                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="category-banner container">
            <div class="row">
                <div class="col-md-6">
                    <div class="category-banner__item border-radius-10 mb-5">
                        <img loading="lazy" class="h-auto" src="images/Homepage.png" width="690" height="665" alt="" />
                        <div class="category-banner__item-content">
                            <h3 class="mb-0">SeaFood</h3>
                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop
                                Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-banner__item border-radius-10 mb-5">
                        <img loading="lazy" class="h-auto" src="images/Homepage2.png" width="690" height="665" alt="" />
                        <div class="category-banner__item-content">
                            <h3 class="mb-0">Sea Fish</h3>
                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="products-grid container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                    <img loading="lazy" src="{{ asset('uploads/product/' . $product->image) }}" width="330"
                                        height="400" alt="{{ $product->name }}" class="pc__img">
                                </a>
                            </div>
                            <div class="pc__info position-relative">
                                <h6 class="pc__title">
                                    <a
                                        href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                </h6>
                                <div class="product-card__price d-flex align-items-center">
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
            <!-- /.row -->

            <div class="text-center mt-2">
                <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="{{ route('shop') }}">Load
                    More</a>
            </div>
        </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

</main>
