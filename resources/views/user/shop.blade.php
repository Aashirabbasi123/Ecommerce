@extends('user.components.master')

@section('content')
    @include('user.components.navbar')
    @stack('styles')
    <style>
        /* ===== Swiper Slide Border with Hover Effect ===== */
        .swiper-slide .slide-split {
            border: 4px solid #0077b6;
            /* Ocean Blue */
            border-radius: 14px;
            /* Slightly more rounded */
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 0 rgba(0, 0, 0, 0);
            /* No shadow initially */
            background-color: #fff;
            /* White bg for contrast */
        }

        .swiper-slide .slide-split:hover {
            border-color: #0096c7;
            /* Light aqua-blue hover */
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 102, 153, 0.3);
        }

        /* ===== Quantity Input Group ===== */
        .input-group {
            display: inline-flex;
            align-items: center;
            border: 1.8px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            width: 140px;
            /* Slightly wider for comfort */
            background-color: #fafafa;
            box-shadow: inset 0 1px 3px rgb(0 0 0 / 0.1);
            transition: border-color 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .input-group button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-weight: 700;
            font-size: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
        }

        .input-group button:hover {
            background-color: #0056b3;
        }

        .quantity-input {
            width: 60px;
            border: none;
            text-align: center;
            font-size: 18px;
            padding: 10px 0;
            outline: none;
            background-color: transparent;
            font-weight: 600;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            -moz-appearance: textfield;
            /* Firefox: remove number input arrows */
        }

        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Mobile first: chhoti screen ke liye base styles pehle se hain */

        /* Medium screens (tablets) ke liye tweaks */
        @media (min-width: 600px) {
            .input-group {
                width: 180px;
                /* thoda aur wide */
            }

            .quantity-input {
                width: 80px;
                font-size: 20px;
            }

            .input-group button {
                min-width: 50px;
                font-size: 22px;
            }
        }

        /* Large screens (desktops) ke liye */
        @media (min-width: 992px) {
            .input-group {
                width: 220px;
            }

            .quantity-input {
                width: 100px;
                font-size: 22px;
            }

            .input-group button {
                min-width: 60px;
                font-size: 24px;
            }
        }
    </style>
    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div>

                <div class="pt-4 pt-lg-0"></div>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Product Categories
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0">
                                    @foreach ($categories as $Category)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" class="chk-brand" name="categories"
                                                    value="{{ $Category->id }}" @if (in_array($Category->id, explode(',', $f_categories ?? ''))) checked @endif />
                                                {{ $Category->name }}
                                            </span>
                                            <span class="text-right float-end">
                                                {{ optional($Category->products)->count() }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion" id="brand-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-brand">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                                aria-controls="accordion-filter-brand">
                                Brands
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                            <div class="search-field multi-select accordion-body px-0 pb-0">
                                <ul class="list list-inline mb-0 brand-list">
                                    @foreach ($brands as $brand)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" name="brands" value="{{ $brand->id }}" class="chk-brand"
                                                    @if (in_array($brand->id, explode(',', $f_brands ?? ''))) checked @endif>
                                                {{ $brand->name }}
                                            </span>
                                            <span class="text-right float-end">
                                                {{ $brand->products->count() }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shop-list flex-grow-1">
                <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
                                                "autoplay": {
                                                  "delay": 5000
                                                },
                                                "slidesPerView": 1,
                                                "effect": "fade",
                                                "loop": true,
                                                "pagination": {
                                                  "el": ".slideshow-pagination",
                                                  "type": "bullets",
                                                  "clickable": true
                                                }
                                              }'>

                    <div class="swiper-wrapper">

                        <!-- Black Pomfret Slide -->
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Black <br /><strong>POMFRET</strong>
                                        </h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Black Pomfret (Paplet) is a popular seafood fish with delicate flavor and soft
                                            meat.
                                            Best enjoyed grilled, fried, or in spicy curries, rich in protein and omega-3.
                                        </p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="images/shop/banner.jpg" width="630" height="450"
                                            alt="Black Pomfret Fish" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Prawns Slide -->
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #e6f5f0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Juicy <br /><strong>PRAWNS</strong>
                                        </h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Fresh prawns – tender, juicy and full of flavor.
                                            Perfect for grilling, sizzling platters, or cooked in spicy curry.
                                        </p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #e6f5f0;">
                                        <img loading="lazy" src="images/shop/banner.jpg" width="630" height="450"
                                            alt="Juicy Prawns" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lobster Slide -->
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #f0f5e6;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Premium <br /><strong>LOBSTER</strong>
                                        </h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Succulent lobster tails cooked in butter and herbs.
                                            A luxury seafood experience rich in taste, protein, and nutrients.
                                        </p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f0f5e6;">
                                        <img loading="lazy" src="images/shop/banner.jpg" width="630" height="450"
                                            alt="Premium Lobster" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Red Snapper Slide -->
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #e6f0f5;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Grilled <br /><strong>RED SNAPPER</strong>
                                        </h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Red Snapper is a flavorful fish, perfect for grilling with spices.
                                            Firm texture and mild taste make it a true seafood favorite.
                                        </p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #e6f0f5;">
                                        <img loading="lazy" src="images/shop/banner.jpg" width="630" height="450"
                                            alt="Grilled Red Snapper" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Crab Slide -->
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #f5f0e6;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Fresh <br /><strong>CRAB</strong>
                                        </h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Sweet, juicy crab meat served in butter garlic or masala.
                                            A special seafood delicacy enjoyed worldwide.
                                        </p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5f0e6;">
                                        <img loading="lazy" src="images/shop/banner.jpg" width="630" height="450"
                                            alt="Fresh Crab" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Calamari Slide -->
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                    style="background-color: #eaf5f0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                            Crispy <br /><strong>CALAMARI</strong>
                                        </h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                            Calamari (Squid) fried golden, crunchy outside and tender inside.
                                            Served with lemon wedges and tangy sauces.
                                        </p>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #eaf5f0;">
                                        <img loading="lazy" src="images/shop/banner.jpg" width="630" height="450"
                                            alt="Crispy Calamari" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="container p-3 p-xl-5">
                        <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2">
                        </div>

                    </div>
                </div>

                <div class="mb-3 pb-2 pb-xl-3"></div>

                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                    </div>

                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                            aria-label="Page size" id="pagesize" name="pagesize" style="margin-right:20px;">
                            <option value="12" {{ $size == 12 ? 'selected' : '' }} selected>Show</option>
                            <option value="24" {{ $size == 24 ? 'selected' : '' }}>24</option>
                            <option value="48" {{ $size == 48 ? 'selected' : '' }}>48</option>
                            <option value="102" {{ $size == 102 ? 'selected' : '' }}>102</option>

                        </select>
                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                            aria-label="Sort Items" id="orderby" name="orderby">
                            <option value="-1" {{ $order == -1 ? 'selected' : '' }}>Default</option>
                            <option value="1" {{ $order == 1 ? 'selected' : '' }}>Date, New To Old</option>
                            <option value="2" {{ $order == 2 ? 'selected' : '' }}>Date, Old To New</option>
                            <option value="3" {{ $order == 3 ? 'selected' : '' }}>Price, Low To High</option>
                            <option value="4" {{ $order == 4 ? 'selected' : '' }}>Price, High To Low</option>
                        </select>

                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        <div class="col-size align-items-center order-1 d-none d-lg-flex">
                            <span class="text-uppercase fw-medium me-2">View</span>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="2">2</button>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="3">3</button>
                            <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                                data-cols="4">4</button>
                        </div>

                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                                data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @foreach ($products as $product)
                        @php
                            $discount = 0;
                            if ($product->sale_price && $product->sale_price < $product->regular_price) {
                                $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                            }
                        @endphp
                        <div class="product-card-wrapper">
                            <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                <div class="pc__img-wrapper" style="position: relative;">
                                    @if($discount > 0)
                                        <div
                                            style="position: absolute; top: 10px; left: 10px; background: red; color: white; padding: 5px 8px; font-weight: bold; border-radius: 4px; z-index: 10;">
                                            -{{ $discount }}%
                                        </div>
                                    @endif

                                    <div class="swiper-container background-img js-swiper-slider"
                                        data-settings='{"resizeObserver": true}'>
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                                    <img loading="lazy" src="{{ asset('uploads/product/' . $product->image) }}"
                                                        height="400" alt="{{ $product->name }}" class="pc__img">
                                                </a>
                                            </div>
                                            @foreach (explode(',', $product->images ?? '') as $imageFile)
                                                @if (!empty($imageFile))
                                                    <div class="swiper-slide">
                                                        <a href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">
                                                            <img loading="lazy" src="{{ asset('uploads/product/' . $imageFile) }}"
                                                                width="330" height="400" alt="{{ $product->name }}" class="pc__img">
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11">
                                                <use href="#icon_prev_sm" />
                                            </svg></span>
                                        <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11">
                                                <use href="#icon_next_sm" />
                                            </svg></span>
                                    </div>

                                    @if (session()->has('cart') && array_key_exists($product->id, session('cart')))
                                        <a href="{{ route('cart') }}"
                                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn btn-warning mb-3">
                                            Go To Cart
                                        </a>
                                    @else
                                        <!-- Trigger Modal -->
                                        <button type="button"
                                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                            data-bs-toggle="modal" data-bs-target="#cuttingOptionModal{{ $product->id }}">
                                            Add To Cart
                                        </button>

                                        <!-- Cutting Option Modal -->
                                        <div class="modal fade" id="cuttingOptionModal{{ $product->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('add.cart') }}" class="cutting-form">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Select Cutting Option</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <select class="form-control cutting_option" name="cutting_option"
                                                                required>
                                                                <option value="">Choose an option</option>
                                                                <option value="whole_uncleaned">Whole & Uncleaned</option>
                                                                <option value="whole_gutted">Whole & Gutted</option>
                                                                <option value="headless_gutted">Headless & Gutted</option>
                                                                <option value="slices_with_skin_bone">Slices with Skin & Centre Bone
                                                                </option>
                                                                <option value="boneless_biscuits">Boneless Biscuits</option>
                                                                <option value="boneless_fillet">Boneless Fillet</option>
                                                                <option value="boneless_fingers">Boneless Fingers</option>
                                                            </select>

                                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                                            <input type="hidden" name="image" value="{{ $product->image }}">
                                                            <input type="hidden" name="price"
                                                                value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}">

                                                            <!-- ✅ Quantity Selector -->
                                                            <div class="input-group">
                                                                <button type="button" class="decrease-btn">-</button>
                                                                <input type="number" name="quantity" class="quantity-input"
                                                                    value="3" min="3">
                                                                <button type="button" class="increase-btn">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                </div>
                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $product->category->name }}</p>
                                    <h6 class="pc__title">
                                        <a
                                            href="{{ route('detailpage', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        @if ($product->sale_price && $product->sale_price < $product->regular_price)
                                            <span class="money price price-old">
                                                <s>Rs{{ $product->regular_price }}</s>
                                            </span>
                                            <span class="money price text-secondary">
                                                Rs{{ $product->sale_price }}
                                            </span>
                                        @else
                                            <span class="money price text-secondary">
                                                Rs{{ $product->regular_price }}
                                            </span>
                                        @endif

                                    </div>
                                    @if (session()->has('wishlist') && array_key_exists($product->id, session('wishlist')))
                                        <form method="POST" action="{{ route('wishlist.remove', ['id' => $product->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0"
                                                style="color:orange;" title="Already in Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="red"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('add.wishlist') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                            <input type="hidden" name="quantity" value="3">
                                            <input type="hidden" name="image" value="{{ $product->image }}">
                                            <input type="hidden" name="price"
                                                value="{{ $product->sale_price ?? $product->regular_price }}">

                                            <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="divider">
                    <div class="flex item-center jsutify-between flex-wrap gap10 wgp-pagination">
                        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
    @include('user.components.footer')
    <form id="frmfilter" method="GET" action="{{ route('shop') }}">
        <input type="hidden" name="page" value="{{ $products->currentPage() }}" />
        <input type="hidden" name="size" id="size" value="{{ $size }}" />
        <input type="hidden" name="order" id="order" value="{{ $order }}" />
        <input type="hidden" name="brands" id="hdnBrands" />
        <input type="hidden" name="categories" id="hdnCategories" />
    </form>
@endsection
@push('scripts')
    <script>
        $(function () {
            $("#pagesize").on("change", function () {
                $("#size").val($(this).val());
                $("#frmfilter").submit();
            });

            $("#orderby").on("change", function () {
                $("#order").val($(this).val());
                $("#frmfilter").submit();
            });

            $("input[name='brands']").on("change", function () {
                let brands = "";
                $("input[name='brands']:checked").each(function () {
                    brands += brands === "" ? $(this).val() : "," + $(this).val();
                });
                $("#hdnBrands").val(brands);
                $("#frmfilter").submit();
            });
            $("input[name='categories']").on("change", function () {
                let categories = "";
                $("input[name='categories']:checked").each(function () {
                    categories += categories === "" ? $(this).val() : "," + $(this).val();
                });
                $("#hdnCategories").val(categories);
                $("#frmfilter").submit();
            });
        });
        document.querySelectorAll(".cutting-form").forEach(form => {
            form.addEventListener("submit", function (e) {
                let cuttingOption = this.querySelector(".cutting_option").value;
                if (cuttingOption === "") {
                    e.preventDefault();
                    alert("⚠️ Please select a Cutting Option before adding to cart!");
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".increase-btn").forEach(btn => {
                btn.addEventListener("click", function () {
                    let input = this.closest(".input-group").querySelector(".quantity-input");
                    input.value = parseInt(input.value) + 1;
                });
            });

            document.querySelectorAll(".decrease-btn").forEach(btn => {
                btn.addEventListener("click", function () {
                    let input = this.closest(".input-group").querySelector(".quantity-input");
                    let current = parseInt(input.value);
                    if (current > 3) {
                        input.value = current - 1;
                    } else {
                        input.value = 3;
                    }
                });
            });
        });

    </script>
@endpush
