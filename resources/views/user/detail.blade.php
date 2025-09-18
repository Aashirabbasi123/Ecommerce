@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    @stack('styles')
    <style>
        .avatar-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #007bff;
            /* blue background */
            color: #fff;
            font-weight: bold;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
        }

        .product-single__addtocart,
        .cart-or-guide-wrapper {
            margin-top: 15px;
        }

        .btn-addtocart,
        .btn-warning {
            width: 100%;
            max-width: 200px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            display: block;
            margin-top: 10px;
            text-align: center;
            border-radius: 4px;
        }

        .cart-or-guide-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Modal container */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);/
        }

        .cutting-guide-link {
            color: #0077be;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
            transition: text-decoration 0.3s ease;
        }

        .cutting-guide-link:hover {
            text-decoration: underline;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            position: relative;
        }

        /* Close button */
        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
        }

        /* Cutting images grid */
        .modal-content>div>div {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 20px;
        }

        .cutting-image {
            width: 100%;
            height: auto;
            border-radius: 4px;
            object-fit: cover;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Title below first image */
        .image-title {
            text-align: center;
            font-weight: bold;
            margin-top: 5px;
        }

        .loader {
            --s: 20px;
            height: calc(var(--s)*0.9);
            width: calc(var(--s)*5);
            --v1: transparent, #000 0.5deg 108deg, #0000 109deg;
            --v2: transparent, #000 0.5deg 36deg, #0000 37deg;
            -webkit-mask:
                conic-gradient(from 54deg at calc(var(--s)*0.68) calc(var(--s)*0.57), var(--v1)),
                conic-gradient(from 90deg at calc(var(--s)*0.02) calc(var(--s)*0.35), var(--v2)),
                conic-gradient(from 126deg at calc(var(--s)*0.5) calc(var(--s)*0.7), var(--v1)),
                conic-gradient(from 162deg at calc(var(--s)*0.5) 0, var(--v2));
            -webkit-mask-size: var(--s) var(--s);
            -webkit-mask-composite: xor, destination-over;
            mask-composite: exclude, add;
            -webkit-mask-repeat: repeat-x;
            background: linear-gradient(#ffb940 0 0) left/0% 100% #ddd no-repeat;
            animation: l20 8s infinite linear;
        }

        @keyframes l20 {

            90%,
            100% {
                background-size: 100% 100%
            }
        }

        @media screen and (max-width: 576px) {
            .avatar-circle {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .btn-addtocart,
            .btn-warning {
                max-width: 100%;
                font-size: 12px;
                padding: 8px 15px;
            }

            .modal-content {
                width: 95%;
                padding: 15px;
            }

            .modal-content>div>div {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }

        /* Medium devices (tablets) */
        @media screen and (min-width: 577px) and (max-width: 992px) {
            .avatar-circle {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }

            .btn-addtocart,
            .btn-warning {
                max-width: 180px;
                font-size: 13px;
            }

            .modal-content {
                width: 90%;
            }
        }

        /* Large devices (desktops/laptops) */
        @media screen and (min-width: 993px) {
            .avatar-circle {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .btn-addtocart,
            .btn-warning {
                max-width: 200px;
                font-size: 14px;
            }

            .modal-content {
                width: 80%;
            }
        }
    </style>
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container main-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img src="{{ asset('uploads/product/' . $product->image) }}" width="674"
                                            height="550" />
                                        <a data-fancybox="gallery" href="{{ asset('uploads/product/' . $product->image) }}"
                                            title="Zoom">
                                            <svg width="16" height="16">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>
                                    @foreach (explode(',', $product->images ?? '') as $imageFile)
                                        @php $imageFile = trim($imageFile); @endphp
                                        @if (!empty($imageFile))
                                            <div class="swiper-slide product-single__image-item">
                                                <img src="{{ asset('uploads/product/' . $imageFile) }}" width="674" height="550" />
                                                <a data-fancybox="gallery" href="{{ asset('uploads/product/' . $imageFile) }}"
                                                    title="Zoom">
                                                    <svg width="16" height="16">
                                                        <use href="#icon_zoom" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <!-- Slider navigation -->
                                <div class="swiper-button-prev">
                                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnails -->
                        <div class="product-single__thumbnail">
                            <div class="swiper-container thumbnail-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/product/' . $product->image) }}" width="104" height="104"
                                            alt="{{ $product->name }}" />
                                    </div>
                                    @foreach (explode(',', $product->images ?? '') as $imageFile)
                                        @php $imageFile = trim($imageFile); @endphp
                                        @if (!empty($imageFile))
                                            <div class="swiper-slide product-single__image-item">
                                                <img loading="lazy" class="h-auto"
                                                    src="{{ asset('uploads/product/' . $imageFile) }}" width="104" height="104"
                                                    alt="{{ $product->name }}" />
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                        </div><!-- /.breadcrumb -->

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">

                            @if ($previous)
                                <a href="{{ route('detailpage', ['product_slug' => $previous->slug]) }}"
                                    class="text-uppercase fw-medium">
                                    <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_md" />

                                    </svg>
                                    <span class="menu-link menu-link_us-s">Prev</span>
                                </a>
                            @endif

                            @if ($next)
                                <a href=" {{ route('detailpage', ['product_slug' => $next->slug]) }}"
                                    class="text-uppercase fw-medium">
                                    <span class="menu-link menu-link_us-s">Next</span> <svg width="10" height="10"
                                        viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_md" />
                                    </svg>
                                </a>
                            @endif

                        </div>

                        <!-- /.shop-acs -->
                    </div>
                    <h1 class="product-single__name">{{ $product->name }}</h1>

                    <div class="product-single__rating">
                        <div class="loader"></div>
                        <span class="reviews-note text-secondary ms-1">
                            Reviews
                        </span>
                    </div>
                    <div class="product-single__price">
                        <span class="current-price">
                            @if ($product->sale_price)
                                <s>Rs{{ $product->regular_price }}</s> Rs{{ $product->sale_price }}*
                            @else
                                Rs{{ $product->regular_price }}
                            @endif
                        </span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>
                    <!-- Cutting Option Section -->
                    <form name="addtocart-form" method="post" action="{{ route('add.cart') }}">
                        @csrf
                        <div class="cutting-option mb-3">
                            <h4>Cutting Option</h4>
                            <select class="form-control" id="cuttingOption" name="cutting_option" required>
                                <option value="">Choose an option</option>
                                <option value="whole_uncleaned" data-price="0">Whole & Uncleaned </option>
                                <option value="whole_gutted" data-price="50">Whole & Gutted </option>
                                <option value="headless_gutted" data-price="100">Headless & Gutted</option>
                                <option value="slices_with_skin_bone" data-price="150">Slices with Skin & Centre Bone
                                </option>
                                <option value="boneless_biscuits" data-price="200">Boneless Biscuits </option>
                                <option value="boneless_fillet" data-price="250">Boneless Fillet </option>
                                <option value="boneless_fingers" data-price="300">Boneless Fingers</option>
                            </select>
                        </div>

                        <div class="product-single__addtocart">
                            <div class="qty-control position-relative">
                                <input type="number" id="quantity" name="quantity" value="3" min="3"
                                    class="qty-control__number text-center">
                                <div class="qty-control__reduce">-</div>
                                <div class="qty-control__increase">+</div>
                            </div>
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="hidden" id="finalPrice" name="price"
                                value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}">
                            <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">
                                Add to Cart
                            </button>
                        </div>
                    </form>

                    <a href="#" id="openModalBtn" class="cutting-guide-link">Cutting Guide</a>
                    <div id="cuttingGuideModal" class="modal">
                        <div class="modal-content">
                            <span class="close" id="closeModalBtn">&times;</span>
                            <h2>Cutting Guide</h2>

                            <div>
                                <div>
                                    <img src="/images/cuttingGuide/new1.jpg" class="cutting-image" alt="Whole & Uncleaned">
                                    <div>
                                        <img src="/images/cuttingGuide/new.jpg" class="cutting-image"
                                            alt="Whole & Uncleaned">
                                    </div>
                                    <div>
                                        <img src="/images/cuttingGuide/new3.jpg" class="cutting-image"
                                            alt="Whole
                                                                                                                    & Uncleaned">
                                    </div>
                                    <div> <img src="/images/cuttingGuide/new2.jpg" class="cutting-image"
                                            alt="Whole & Uncleaned">
                                    </div>
                                    <div>
                                        <img src="/images/cuttingGuide/new4.jpg" class="cutting-image"
                                            alt="Whole & Uncleaned">
                                    </div>
                                    <div>
                                        <img src="/images/cuttingGuide/new5.jpg" class="cutting-image"
                                            alt="Whole & Uncleaned">
                                    </div>
                                    <div>
                                        <img src="/images/cuttingGuide/new6.jpg" class="cutting-image"
                                            alt="Whole & Uncleaned">
                                    </div>
                                    <!-- Add more as needed -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-single__addtolinks">
                    @if (session()->has('wishlist') && array_key_exists($product->id, session('wishlist')))
                        <form method=" POST" action="{{ route('wishlist.remove', ['id' => $product->id]) }}"
                            id="remove-wishlist-frm">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart"
                                style="color:orange;" onclick="document.getElementById('remove-wishlist-frm').submit();">

                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-right: 6px;">
                                    <use href="#icon_heart" />
                                </svg>

                                <span>Remove from Wishlist</span>
                            </a>

                        </form>
                    @else
                        <form method="POST" action="{{ route('add.wishlist') }}" id="wishlist-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="hidden" name="price" value="{{ $product->sale_price ?? $product->regular_price }}">
                            <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist"
                                onclick="document.getElementById('wishlist-form').submit();"><svg width="16" height="16"
                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-right: 6px;">
                                    <use href="#icon_heart" />
                                </svg><span>Add to Wishlist</span></a>
                        </form>
                    @endif
                    <script src="js/detailpages-disclosure.html" defer="defer"></script>
                    <script src="js/share.html" defer="defer"></script>
                </div>
                <div class="product-single__meta-info">
                    <div class="meta-item">
                        <label>SKU:</label>
                        <span>{{ $product->SKU }}</span>
                    </div>
                    <div class="meta-item">
                        <label>Categories:</label>
                        <span>{{ $product->category->name }}</span>
                    </div>
                    <div class="meta-item">
                        <svg class="review-star" style="fill:black;">
                            <use href="#icon_star" />
                        </svg>
                        <label>Delivery:</label>
                        <span>Delivery Charges Excluded</span>
                    </div>

                </div>
            </div>
            </div>
            <div class="product-single__detailpages-tab">
                <ul class=" nav nav-tabs" id="myTab" role="tablist">
                    <li class=" nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                            href="#tab-description" role="tab" aria-controls="tab-description"
                            aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab"
                            href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">
                            Reviews ({{ $product->reviews->count() }})
                        </a>
                    </li>
                </ul>

                <div class=" tab-content"> <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                        aria-labelledby="tab-description-tab">
                        <div class="product-single__description">
                            <h3 class="product-single__tittle">{{ $product->name }}</h3>
                            <p class="content w-100">{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                        <h2 class="product-single__reviews-title">Reviews</h2>

                        <!-- Dynamic Reviews List -->
                        <div class="product-single__reviews-list">
                            @forelse($product->reviews as $review)
                                <div class="product-single__reviews-item">
                                    <div class="customer-avatar">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($review->name, 0, 1)) }}
                                        </div>
                                    </div>

                                    <div class="customer-review">
                                        <div class="customer-name">
                                            <h6>{{ $review->name }}</h6>
                                            <div class="reviews-group d-flex">
                                                @for ($i = 1; $i <= 5; $i++) <svg class="review-star" viewBox="0 0 9 9"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        style="fill: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }};">
                                                        <use href="#icon_star" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="review-date">{{ $review->created_at->format('F d, Y') }}</div>
                                        <div class="review-text">
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No Reviews yet. Be the first to review this product!</p>
                            @endforelse
                        </div>

                        <!-- Review Form -->
                        <div class="product-single__review-form">
                            <form action="{{ route('product.addReview', $product->id) }}" method="POST">
                                @csrf
                                <h5>Be the first to Review “{{ $product->name }}”</h5>
                                <p>Your email address will not be published. Required fields are marked *</p>

                                <!-- Rating -->
                                <div class="select-star-rating">
                                    <label>Your rating *</label>
                                    <select name="rating" class="form-control" required>
                                        <option value="">Select Rating</option>
                                        <option value="5">★★★★★</option>
                                        <option value="4">★★★★☆</option>
                                        <option value="3">★★★☆☆</option>
                                        <option value="2">★★☆☆☆</option>
                                        <option value="1">★☆☆☆☆</option>
                                    </select>
                                </div>

                                <!-- Review -->
                                <div class="mb-4">
                                    <textarea name="review" class="form-control form-control_gray" placeholder="Your Review"
                                        cols="30" rows="8" required></textarea>
                                </div>

                                <!-- Name -->
                                <div class="form-label-fixed mb-4">
                                    <label for="form-input-name" class="form-label">Name *</label>
                                    <input name="name" id="form-input-name"
                                        class="form-control form-control-md form-control_gray" required>
                                </div>

                                <!-- Email -->
                                <div class="form-label-fixed mb-4">
                                    <label for="form-input-email" class="form-label">Email address *</label>
                                    <input type="email" name="email" id="form-input-email"
                                        class="form-control form-control-md form-control_gray" required>
                                </div>

                                <!-- Submit -->
                                <div class="form-action">
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section class="products-carousel container">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

            <div id="related_products" class="position-relative">
                <div class="swiper-container js-swiper-slider" data-settings='{
                                                                                                "autoplay": false,
                                                                                                "slidesPerView": 4,
                                                                                                "slidesPerGroup": 4,
                                                                                                "loop": true,
                                                                                                "pagination": {
                                                                                                    "el": "#related_products .products-pagination",
                                                                                                    "type": "bullets",
                                                                                                    "clickable": true
                                                                                                },
                                                                                                "navigation": {
                                                                                                    "nextEl": "#related_products .products-carousel__next",
                                                                                                    "prevEl": "#related_products .products-carousel__prev"
                                                                                                },
                                                                                                "breakpoints": {
                                                                                                    "320": {"slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14},
                                                                                                    "768": {"slidesPerView": 3, "slidesPerGroup": 3, "spaceBetween": 24},
                                                                                                    "992": {"slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 30}
                                                                                                    }
                                                                                                }'>
                    <div class="swiper-wrapper">
                        @foreach ($rproducts as $rproduct)
                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper position-relative">

                                    <a href="{{ route('detailpage', ['product_slug' => $rproduct->slug]) }}">
                                        <img loading="lazy" src="{{ asset('uploads/product/' . $rproduct->image) }}" width="330"
                                            height="400" alt="{{ $rproduct->name }}" class="pc__img">

                                        @foreach (explode(',', $rproduct->images ?? '') as $imageFile)
                                            @if (!empty($imageFile))
                                                <img loading="lazy" src="{{ asset('uploads/product/' . $imageFile) }}" width="330"
                                                    height="400" alt="{{ $rproduct->name }}" class="pc__img pc__img-second">
                                            @endif
                                        @endforeach
                                    </a>
                                    <div>
                                        @if (session()->has('cart') && array_key_exists($rproduct->id, session('cart')))
                                            <a href="{{ route('cart') }}" class="btn btn-warning">Go To Cart</a>
                                        @else
                                            <form method="post" action="{{ route('add.cart') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $rproduct->id }}">
                                                <input type="hidden" name="name" value="{{ $rproduct->name }}">
                                                <input type="hidden" name="image" value="{{ $rproduct->image }}">
                                                <input type="hidden" name="price"
                                                    value="{{ $rproduct->sale_price ?: $rproduct->regular_price }}">
                                                <input type="hidden" name="quantity" value="3">
                                                <button type="submit"
                                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium "
                                                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                            </form>
                                        @endif
                                    </div>

                                </div>

                                {{-- PRODUCT INFO --}}
                                <div class="pc__info text-center">
                                    <p class="pc__category">{{ $rproduct->category->name }}</p>
                                    <h6 class="pc__title">
                                        <a href="{{ route('detailpage', ['product_slug' => $rproduct->slug]) }}">
                                            {{ $rproduct->name }}
                                        </a>
                                    </h6>
                                    <div class="product-card__price">
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
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Navigation Arrows -->
                <div
                    class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div>
                <div
                    class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div>

                <!-- Pagination -->
                <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
            </div>
        </section>
    </main>
    @include('user.components.footer')
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var mainSlider = new Swiper('.main-slider', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbnailSlider,
            },
        });

        var thumbnailSlider = new Swiper('.thumbnail-slider', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        const modal = document.getElementById("cuttingGuideModal");
        const btn = document.getElementById("openModalBtn");
        const span = document.getElementById("closeModalBtn");

        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        document.getElementById("addtocart-form").addEventListener("submit", function (e) {
            let cuttingOption = document.getElementById("cutting_option").value;
            if (cuttingOption === "") {
                e.preventDefault();
                alert("⚠️ Please select a Cutting Option before adding to cart!");
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const qtyInput = document.querySelector(".qty-control__number");
            const btnIncrease = document.querySelector(".qty-control__increase");
            const btnDecrease = document.querySelector(".qty-control__reduce");

            // Increase (+)
            btnIncrease.addEventListener("click", function () {
                let current = parseInt(qtyInput.value) || 3;
                qtyInput.value = current + 1;
            });

            // Decrease (-) but never below 5
            btnDecrease.addEventListener("click", function () {
                let current = parseInt(qtyInput.value) || 3;
                if (current > 3) {
                    qtyInput.value = current - 1;
                } else {
                    qtyInput.value = 3; // lock at 5
                }
            });

            // Agar banda manually type kare to bhi 5 se neeche na jaaye
            qtyInput.addEventListener("input", function () {
                let current = parseInt(qtyInput.value);
                if (isNaN(current) || current < 3) {
                    qtyInput.value = 3;
                }
            });
        });
    </script>
@endpush
