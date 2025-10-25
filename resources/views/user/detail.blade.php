@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}" type="text/css" />
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="product-single__media">

                        @php
                            $discount = 0;
                            if ($product->sale_price && $product->sale_price < $product->regular_price) {
                                $discount = round(
                                    (($product->regular_price - $product->sale_price) / $product->regular_price) * 100,
                                );
                            }
                        @endphp

                        <!-- SIMPLIFIED MAIN SLIDER -->
                        <div class="product-single__image">
                            <div class="swiper main-slider">
                                <div class="swiper-wrapper">
                                    {{-- Main Image --}}
                                    <div class="swiper-slide">
                                        @if ($discount > 0)
                                            <div class="discount-badge">-{{ $discount }}%</div>
                                        @endif
                                        <div class="zoom-container">
                                            <img src="{{ asset('uploads/product/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="zoom-image" data-zoomable="true">
                                        </div>
                                    </div>

                                    {{-- Additional Images --}}
                                    @foreach (explode(',', $product->images ?? '') as $imageFile)
                                        @php $imageFile = trim($imageFile); @endphp
                                        @if (!empty($imageFile))
                                            <div class="swiper-slide">
                                                @if ($discount > 0)
                                                    <div class="discount-badge">-{{ $discount }}%</div>
                                                @endif
                                                <div class="zoom-container">
                                                    <img src="{{ asset('uploads/product/' . $imageFile) }}"
                                                        alt="{{ $product->name }}" class="zoom-image" data-zoomable="true">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Swiper Navigation -->
                                <div class="swiper-button-next">
                                    <svg width="12" height="12" viewBox="0 0 12 12"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </div>
                                <div class="swiper-button-prev">
                                    <svg width="12" height="12" viewBox="0 0 12 12"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Thumbnail Slider --}}
                            <div class="product-single__thumbnail">
                                <div class="swiper thumbnail-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="{{ asset('uploads/product/' . $product->image) }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                        @foreach (explode(',', $product->images ?? '') as $imageFile)
                                            @php $imageFile = trim($imageFile); @endphp
                                            @if (!empty($imageFile))
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('uploads/product/' . $imageFile) }}"
                                                        alt="{{ $product->name }}">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-1 pb-md-1">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="{{ route('dashboard') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="{{ route('shop') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">The
                                Shop</a>
                        </div><!-- /.breadcrumb -->

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">

                            @if ($previous)
                                <a href="{{ route('detailpage', ['product_slug' => $previous->slug]) }}"
                                    class="text-uppercase fw-medium">
                                    <svg width="10" height="10" viewBox="0 0 25 25"
                                        xmlns="http://www.w3.org/2000/svg">
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
                        @php
                            $roundedRating = round($averageRating ?? 0, 1);
                            $filledStars = floor($roundedRating);
                            $halfStar = $roundedRating - $filledStars >= 0.5;
                        @endphp

                        <div class="star-display" style="font-size: 22px; color: #FFD700;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $filledStars)
                                    ★
                                @elseif ($halfStar && $i == $filledStars + 1)
                                    <span style="color: #ccc;">★</span>
                                @else
                                    <span style="color: #ccc;">☆</span>
                                @endif
                            @endfor
                        </div>

                        <span class="reviews-note text-secondary ms-2">
                            {{ $roundedRating }}/5 ({{ $reviewCount }} Reviews)
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
                        <p>{!! $product->short_description !!}</p>
                    </div>
                    <p><strong>Note:</strong> All our seafood prices are based on the weight before cleaning or cutting. The
                        final weight at delivery will depend on the type of cut or preparation you select.</p>

                    <!-- Cutting Option Section -->
                    @php
                        $cuttingOptions = json_decode($product->cutting_options ?? '[]', true);

                        $optionLabels = [
                            'whole_uncleaned' => 'Whole & Uncleaned - ثابت (بغیر صفائی کے)',
                            'whole_gutted' => 'Whole & Gutted - مکمل (صاف شدہ)',
                            'headless_gutted' => 'Headless & Gutted - بغیر سر کے (صاف شدہ)',
                            'slices_with_skin_bone' => 'Slices with Skin & Centre Bone - ٹکڑے (چمڑی اور ہڈی سمیت)',
                            'boneless_biscuits' => 'Boneless Biscuits - بغیر ہڈی کے بسکٹ کٹ',
                            'boneless_fillet' => 'Boneless Fillet - بغیر ہڈی کے فلٹ',
                            'boneless_fingers' => 'Boneless Fingers - بغیر ہڈی کے فنگرز',
                            'headless_but_shell_on' => 'Headless but shell on - بغیر سر کے مگر چھلکے سمیت',
                            'peeled_and_Deveined_with_tail_on' =>
                                'Peeled and Deveined with tail on - چھلا ہوا اور صاف شدہ (دم سمیت)',
                            'fully_Peeled_and_Deveined' =>
                                'Fully Peeled and Deveined - مکمل طور پر چھلا ہوا اور صاف شدہ',
                            'tempura_Cut_Prawns' => 'Tempura Cut Prawns - ٹیمپورا کٹ جھینگے',
                        ];

                        $optionPrices = [
                            'whole_uncleaned' => 0,
                            'whole_gutted' => 50,
                            'headless_gutted' => 100,
                            'slices_with_skin_bone' => 150,
                            'boneless_biscuits' => 200,
                            'boneless_fillet' => 250,
                            'boneless_fingers' => 300,
                        ];
                    @endphp

                    <form name="addtocart-form" method="post" action="{{ route('add.cart') }}">
                        @csrf
                        <div class="cutting-option mb-3">
                            <h4>
                                Cutting Option
                                <a href="#" id="openModalBtn" class="cutting-guide-link" style="margin-left: 10px;">
                                    Cutting Guide
                                </a>
                            </h4>

                            <select class="form-control" id="cuttingOption" name="cutting_option" required>
                                <option value="">Choose an option</option>

                                @foreach ($cuttingOptions as $option)
                                    @if (isset($optionLabels[$option]))
                                        <option value="{{ $option }}"
                                            data-price="{{ $optionPrices[$option] ?? 0 }}">
                                            {!! $optionLabels[$option] !!}
                                        </option>
                                    @else
                                        {{-- fallback in case label missing --}}
                                        <option value="{{ $option }}">{{ ucfirst(str_replace('_', ' ', $option)) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>


                        <div class="product-single__addtocart">
                            <div class="qty-control position-relative" style="display: inline-block; position: relative;">
                                <input type="number" id="quantity" name="quantity" value="3" min="3"
                                    class="qty-control__number text-center"
                                    style="width:80px; padding-right:30px; text-align:center;">
                                <span
                                    style="position:absolute; right:35px; top:50%; transform:translateY(-50%); pointer-events:none;">kg</span>

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
                    <div id="cuttingGuideModal" class="modal">
                        <div class="modal-content">
                            <span class="close" id="closeModalBtn">&times;</span>
                            <h2>Cutting Guide</h2>
                            <div>
                                <div>
                                    <img src="/images/cuttingGuide/new1.jpg" class="cutting-image"
                                        alt="Whole & Uncleaned">
                                    <div>
                                        <img src="/images/cuttingGuide/new.jpg" class="cutting-image"
                                            alt="Whole & Uncleaned">
                                    </div>
                                    <div>
                                        <img src="/images/cuttingGuide/new3.jpg" class="cutting-image"
                                            alt="Whole & Uncleaned">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-single__addtolinks">
                    @if (session()->has('wishlist') && array_key_exists($product->id, session('wishlist')))
                        <form method="POST" action="{{ route('wishlist.remove', ['id' => $product->id]) }}"
                            id="remove-wishlist-frm">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart"
                                style="color:orange;" onclick="document.getElementById('remove-wishlist-frm').submit();">

                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px;">
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
                            <input type="hidden" name="quantity" value="3">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="hidden" name="price"
                                value="{{ $product->sale_price ?? $product->regular_price }}">
                            <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist"
                                onclick="document.getElementById('wishlist-form').submit();">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px;">
                                    <use href="#icon_heart" />
                                </svg>
                                <span>Add to Wishlist</span>
                            </a>
                        </form>
                    @endif
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
                            <p class="content w-100">{!! $product->description !!}</p>
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
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="review-star" viewBox="0 0 9 9"
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
                                <h5>Be the first to Review "{{ $product->name }}"</h5>
                                <p>Your email address will not be published. Required fields are marked *</p>

                                <!-- Rating -->
                                <div class="rating-container">
                                    <label>Your Rating *</label>
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="rating" value="5" required />
                                        <label for="star5">★</label>

                                        <input type="radio" id="star4" name="rating" value="4" />
                                        <label for="star4">★</label>

                                        <input type="radio" id="star3" name="rating" value="3" />
                                        <label for="star3">★</label>

                                        <input type="radio" id="star2" name="rating" value="2" />
                                        <label for="star2">★</label>

                                        <input type="radio" id="star1" name="rating" value="1" />
                                        <label for="star1">★</label>
                                    </div>
                                </div>


                                <!-- Review -->
                                <div class="mb-4">
                                    <textarea name="review" class="form-control form-control_gray" placeholder="Your Review" cols="30"
                                        rows="8" required></textarea>
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
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
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
                            "320": {"slidesPerView": 1, "slidesPerGroup": 1, "spaceBetween": 12},
                            "576": {"slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 16},
                            "768": {"slidesPerView": 3, "slidesPerGroup": 3, "spaceBetween": 24},
                            "992": {"slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 30}
                        }
                    }'>
                    <div class="swiper-wrapper">
                        @foreach ($rproducts as $rproduct)
                            @php
                                $discount = 0;
                                if ($rproduct->sale_price && $rproduct->sale_price < $rproduct->regular_price) {
                                    $discount = round(
                                        (($rproduct->regular_price - $rproduct->sale_price) /
                                            $rproduct->regular_price) *
                                            100,
                                    );
                                }
                            @endphp

                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper position-relative">
                                    {{-- Discount Badge --}}
                                    @if ($discount > 0)
                                        <div class="discount-badge"
                                            style="position:absolute; top:10px; left:10px; background:red; color:white; padding:5px 10px; font-weight:bold; border-radius:4px; z-index:5;">
                                            -{{ $discount }}%
                                        </div>
                                    @endif

                                    <a href="{{ route('detailpage', ['product_slug' => $rproduct->slug]) }}">
                                        <img loading="lazy" src="{{ asset('uploads/product/' . $rproduct->image) }}"
                                            width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img">

                                        @foreach (explode(',', $rproduct->images ?? '') as $imageFile)
                                            @if (!empty($imageFile))
                                                <img loading="lazy" src="{{ asset('uploads/product/' . $imageFile) }}"
                                                    width="330" height="400" alt="{{ $rproduct->name }}"
                                                    class="pc__img pc__img-second">
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
                                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                                    data-aside="cartDrawer" title="Add To Cart">
                                                    Add To Cart
                                                </button>
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

                                    {{-- ✅ Price Section --}}
                                    <div class="product-card__price">
                                        @if ($rproduct->sale_price && $rproduct->sale_price < $rproduct->regular_price)
                                            <span class="money price price-old text-muted"
                                                style="text-decoration: line-through;">
                                                Rs{{ $rproduct->regular_price }}
                                            </span>
                                            <span class="money price text-danger fw-bold">
                                                Rs{{ $rproduct->sale_price }}
                                            </span>
                                        @else
                                            <span class="money price text-dark fw-bold">
                                                Rs{{ $rproduct->regular_price }}
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
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // Simple Slider Initialization with Mouse Movement Zoom
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize thumbnail slider
            var thumbnailSlider = new Swiper('.thumbnail-slider', {
                slidesPerView: 'auto',
                spaceBetween: 10,
                freeMode: true,
                watchSlidesProgress: true,
            });

            // Initialize main slider
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

            // Mouse Movement Zoom Functionality
            const zoomImages = document.querySelectorAll('.zoom-image[data-zoomable="true"]');

            zoomImages.forEach(img => {
                const container = img.parentElement;

                img.addEventListener('mousemove', function(e) {
                    const {
                        left,
                        top,
                        width,
                        height
                    } = container.getBoundingClientRect();
                    const x = (e.clientX - left) / width;
                    const y = (e.clientY - top) / height;

                    // Calculate zoom based on mouse position
                    const zoomLevel = 2.5; // 2.5x zoom
                    const translateX = (0.5 - x) * 100;
                    const translateY = (0.5 - y) * 100;

                    img.style.transform =
                        `scale(${zoomLevel}) translate(${translateX}%, ${translateY}%)`;
                    img.style.transition = 'transform 0.1s ease';
                });

                img.addEventListener('mouseleave', function() {
                    img.style.transform = 'scale(1) translate(0, 0)';
                    img.style.transition = 'transform 0.3s ease';
                });

                // Click to toggle zoom (optional)
                img.addEventListener('click', function() {
                    if (img.style.transform === 'scale(2.5) translate(0%, 0%)' ||
                        img.style.transform.includes('scale(2.5)')) {
                        img.style.transform = 'scale(1) translate(0, 0)';
                    } else {
                        img.style.transform = 'scale(2.5) translate(0%, 0%)';
                    }
                });
            });

            // Modal functionality
            const modal = document.getElementById("cuttingGuideModal");
            const btn = document.getElementById("openModalBtn");
            const span = document.getElementById("closeModalBtn");

            if (btn && modal && span) {
                btn.onclick = function() {
                    modal.style.display = "block";
                }

                span.onclick = function() {
                    modal.style.display = "none";
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            }

            // Quantity controls
            const qtyInput = document.querySelector(".qty-control__number");
            const btnIncrease = document.querySelector(".qty-control__increase");
            const btnDecrease = document.querySelector(".qty-control__reduce");

            // Add to cart form validation
            const addToCartForm = document.querySelector('form[name="addtocart-form"]');
            if (addToCartForm) {
                addToCartForm.addEventListener("submit", function(e) {
                    let cuttingOption = document.getElementById("cuttingOption").value;
                    if (cuttingOption === "") {
                        e.preventDefault();
                        alert("⚠️ Please select a Cutting Option before adding to cart!");
                    }
                });
            }
        });

        function submitAddToCartForm(productId) {
            const form = document.getElementById(`addToCartForm-${productId}`);
            if (form) {
                form.submit();
            }
        }
    </script>
@endpush
