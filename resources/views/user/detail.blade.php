@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    <style>
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e63946;
            color: #fff;
            padding: 5px 10px;
            font-size: 0.85rem;
            font-weight: bold;
            border-radius: 6px;
            z-index: 5;
        }

        .avatar-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #007bff;
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
            max-width: 220px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 14px;
            display: block;
            margin-top: 10px;
            text-align: center;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-addtocart:hover,
        .btn-warning:hover {
            transform: scale(1.05);
        }

        .cart-or-guide-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
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
            overflow-y: auto;
            background-color: rgba(0, 0, 0, 0.5);
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
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            position: relative;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
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
            gap: 12px;
            margin-top: 0px;
        }

        .cutting-image {
            width: 100%;
            height: auto;
            border-radius: 6px;
            object-fit: cover;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        /* Title below first image */
        .image-title {
            text-align: center;
            font-weight: bold;
            margin-top: 5px;
            font-size: 14px;
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

        .product-single__image {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .product-single__image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .product-single__image {
                padding: 0 10px;
            }

            .product-single__image img {
                height: auto;
            }
        }

        @keyframes l20 {

            90%,
            100% {
                background-size: 100% 100%
            }
        }

        /* 📱 Small screens (mobiles) */
        @media screen and (max-width: 576px) {
            .avatar-circle {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .btn-addtocart,
            .btn-warning {
                max-width: 100%;
                font-size: 13px;
                padding: 10px 15px;
            }

            .cart-or-guide-wrapper {
                align-items: center;
            }

            .modal-content {
                width: 95%;
                padding: 15px;
                margin-top: 18%;
                /* 🔥 fix: mobile me modal neeche kar diya */
            }

            .modal-content>div>div {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .image-title {
                font-size: 12px;
            }
        }

        /* 📱 Tablets */
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

        /* 💻 Desktops */
        @media screen and (min-width: 993px) {
            .avatar-circle {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .btn-addtocart,
            .btn-warning {
                max-width: 220px;
                font-size: 14px;
            }

            /* .modal-content {
                           width: 75%;
                        } */
        }

        /* ===== Container & General ===== */
        .product-single__addtolinks {
            margin-bottom: 25px;
            display: flex;
            gap: 15px;
        }

        .product-single__addtolinks form {
            margin: 0;
        }

        .menu-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            color: #007bff;
            padding: 8px 14px;
            border: 1.5px solid #007bff;
            border-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            user-select: none;
        }

        .menu-link:hover {
            background-color: #007bff;
            color: white;
            text-decoration: none;
        }

        .menu-link.filled-heart {
            color: orange !important;
            border-color: orange !important;
        }

        .menu-link.filled-heart:hover {
            background-color: orange !important;
            color: white !important;
        }

        /* ===== Meta Info Section ===== */
        .product-single__meta-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 0.95rem;
            color: #555;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            margin-bottom: 30px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 150px;
        }

        .meta-item label {
            font-weight: 700;
            color: #333;
            min-width: 85px;
        }

        .review-star {
            width: 16px;
            height: 16px;
            fill: black;
        }

        /* ===== Tabs ===== */
        .product-single__detailpages-tab {
            margin-top: 30px;
        }

        .nav-tabs {
            display: flex;
            border-bottom: 2px solid #ddd;
            margin-bottom: 0;
        }

        .nav-tabs .nav-item {
            margin-bottom: -2px;
        }

        .nav-tabs .nav-link {
            color: #333;
            padding: 10px 20px;
            border: 1px solid transparent;
            border-bottom: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            background-color: #f5f5f5;
            color: #0d6efd;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-color: #ddd #ddd white;
            background-color: white;
            border-radius: 5px 5px 0 0;
        }

        .thumbnail-slider .swiper-slide img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        /* Tab content area */
        .tab-content {
            border: 1px solid #ddd;
            border-top: none;
            padding: 25px 20px;
            background-color: #fff;
            border-radius: 0 5px 5px 5px;
            min-height: 280px;
        }

        /* ===== Description ===== */
        .product-single__description {
            color: #444;
        }

        .product-single__tittle {
            margin-top: 0;
            margin-bottom: 15px;
            font-weight: 700;
            font-size: 1.8rem;
            color: #222;
        }

        .product-single__description p.content {
            line-height: 1.6;
            font-size: 1rem;
        }

        /* ===== Reviews ===== */
        .product-single__reviews-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: #222;
        }

        .product-single__reviews-list {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 30px;
            padding-right: 10px;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .product-single__reviews-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .customer-avatar .avatar-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #0d6efd;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            text-transform: uppercase;
        }

        .customer-review {
            flex-grow: 1;
        }

        .customer-name h6 {
            margin: 0 0 8px 0;
            font-weight: 700;
            font-size: 1.15rem;
            color: #0d6efd;
        }

        .reviews-group {
            display: flex;
            gap: 4px;
            margin-bottom: 8px;
        }

        .review-star {
            width: 18px;
            height: 18px;
        }

        .review-date {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 10px;
        }

        .review-text p {
            margin: 0;
            font-size: 1rem;
            line-height: 1.4;
            color: #333;
        }

        /* ===== Review Form ===== */
        .product-single__review-form h5 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #222;
        }

        .product-single__review-form p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 20px;
        }

        .select-star-rating label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            font-size: 1rem;
        }

        .select-star-rating select {
            width: 100%;
            padding: 10px 12px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1.5px solid #ccc;
            appearance: none;
            background: white url("data:image/svg+xml;utf8,<svg fill='%23666' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>") no-repeat right 15px center;
            background-size: 14px;
            cursor: pointer;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        textarea.form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1.5px solid #ccc;
            resize: vertical;
            font-family: inherit;
            color: #333;
            transition: border-color 0.3s ease;
        }

        textarea.form-control:focus {
            border-color: #0d6efd;
            outline: none;
        }

        .thumbnail-slider {
            /* max-height: 400px; */
            /* ya jitni height mein sab thumbnails aa jayein */
            /* overflow-y: auto; */
        }

        .form-label-fixed label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            font-size: 1rem;
            color: #333;
        }

        .form-label-fixed input {
            width: 100%;
            padding: 10px 12px;
            font-size: 1rem;
            border-radius: 6px;
            border: 1.5px solid #ccc;
            font-family: inherit;
            color: #333;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-label-fixed input:focus {
            border-color: #0d6efd;
            outline: none;
        }

        .form-action {
            margin-top: 20px;
        }

        .form-action button.btn {
            background-color: #0d6efd;
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .form-action button.btn:hover {
            background-color: #084cd6;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .product-single__addtolinks {
                flex-direction: column;
            }

            .product-single__meta-info {
                flex-direction: column;
                gap: 10px;
            }

            .nav-tabs {
                flex-wrap: wrap;
            }

            .tab-content {
                min-height: auto;
            }

            .product-single__reviews-list {
                max-height: 300px;
                padding-right: 5px;
            }
        }

        /* Make sure slider container shows overflow */
        .product-single__media .swiper-container,
        .product-single__media .swiper-wrapper {
            overflow: visible !important;
        }

        /* Slides ki width / image fit achhi ho */
        .product-single__image-item img {
            width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
        }

        /* Ensure active slide over other slides when overflow */
        .swiper-slide {
            position: relative;
        }

        .swiper-slide-active,
        .swiper-slide-next,
        .swiper-slide-prev {
            z-index: 10;
        }

        /* If parent `.product-single__media` had overflow hidden, override it */
        .product-single__media {
            overflow: visible !important;
        }

        .thumbnail-slider {
            display: flex;
            flex-direction: row;
            gap: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .thumbnail-slider img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            flex-shrink: 0;
            border-radius: 6px;
        }

        /* Mobile View */
        @media (max-width: 768px) {
            .thumbnail-slider {
                flex-direction: column !important;
                /* flex-wrap: nowrap; */
                /* overflow-x: auto; */
                /* -webkit-overflow-scrolling: touch; */
            }

            .thumbnail-slider img {
                width: 80px;
                height: 80px;
            }
        }


        .main-slider {
            width: 100%;
            height: auto;
            /* instead of aspect-ratio */
            max-height: 500px;
            position: relative;
            overflow: hidden;
        }

        .main-slider .swiper-slide img {
            width: 100%;
            height: auto;
            /* keep image height auto */
            object-fit: contain;
            display: block;
        }

        .product-single__media,
        .product-single__media .swiper-container,
        .product-single__media .swiper-wrapper {
            overflow: visible !important;
            /* override overflow on all parents */
        }

        /* ================== Navbar Fix ================== */
        .navbar {
            width: 100%;
            overflow-x: hidden;
            /* prevent horizontal scroll */
        }

        .navbar-nav {
            flex-wrap: wrap;
            /* collapse fix */
        }

        .navbar-toggler {
        border: none;
        background: transparent;
    }

    .navbar-collapse {
        width: 100%;
    }

    /* ================== Image Overflow Fix ================== */
    .product-single__image,
    .product-single__media {
        max-width: 100%;
        overflow: hidden;
    }

    .product-single__image img,
    .main-slider .swiper-slide img,
    .thumbnail-slider img {
        max-width: 100%;
        height: auto;
        object-fit: contain;
        display: block;
    }

    /* Thumbnail Slider Row */
    .thumbnail-slider {
        display: flex;
        flex-direction: row;
        gap: 10px;
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .thumbnail-slider img {
        width: 80px;
        height: 80px;
        border-radius: 6px;
        flex-shrink: 0;
    }

    /* ================== Responsive Fix ================== */
    @media (max-width: 768px) {
        .thumbnail-slider {
            flex-direction: row; /* keep horizontal */
            overflow-x: auto;
        }

        .thumbnail-slider img {
            width: 70px;
            height: 70px;
        }
    }

    @media (max-width: 576px) {
        .navbar-nav {
            text-align: center;
        }

        /* .main-slider {
            max-height: 260px;
        } */

        .thumbnail-slider img {
            width: 60px;
            height: 60px;
        }
    }

    /* ✅ Extra Safety */
    html, body {
        overflow-x: hidden !important;
        max-width: 100%;
    }

        </style>
        <main class="pt-90">
            <div class="mb-md-1 pb-md-3"></div>
            <section class="product-single container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="product-single__media" data-media-type="vertical-thumbnail">

                            @php
                                $discount = 0;
                                if ($product->sale_price && $product->sale_price < $product->regular_price) {
                                    $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                                }
                            @endphp

                            <div class="product-single__image">
                                <div class="swiper-container main-slider">
                                    <div class="swiper-wrapper">
                                        {{-- Main Image --}}
                                        <div class="swiper-slide product-single__image-item" style="position: relative;">
                                            @if ($discount > 0)
                                                <div
                                                    style="position: absolute; top: 10px; left: 10px; background: red; color: white; padding: 5px 8px; font-weight: bold; border-radius: 4px; z-index: 10;">
                                                    -{{ $discount }}%
                                                </div>
                                            @endif

                                            <img src="{{ asset('uploads/product/' . $product->image) }}"
                                                style="width:100%; height:auto;" />

                                            <a data-fancybox="gallery" href="{{ asset('uploads/product/' . $product->image) }}"
                                                title="Zoom">
                                                <svg width="16" height="16">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>

                                        {{-- Additional Images --}}
                                        @foreach (explode(',', $product->images ?? '') as $imageFile)
                                            @php $imageFile = trim($imageFile); @endphp
                                            @if (!empty($imageFile))
                                                <div class="swiper-slide product-single__image-item" style="position: relative;">
                                                    @if ($discount > 0)
                                                        <div
                                                            style="position: absolute; top: 10px; left: 10px; background: red; color: white; padding: 5px 8px; font-weight: bold; border-radius: 4px; z-index: 10;">
                                                            -{{ $discount }}%
                                                        </div>
                                                    @endif

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
                                            <img loading="lazy" class="thumbnail-img"
                                                src="{{ asset('uploads/product/' . $product->image) }}"
                                                alt="{{ $product->name }}" />
                                        </div>
                                        @foreach (explode(',', $product->images ?? '') as $imageFile)
                                            @php $imageFile = trim($imageFile); @endphp
                                            @if (!empty($imageFile))
                                                <div class="swiper-slide product-single__image-item">
                                                    <img loading="lazy" class="thumbnail-img"
                                                        src="{{ asset('uploads/product/' . $imageFile) }}" alt="{{ $product->name }}" />
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
                            <p>{!! $product->short_description !!}</p>
                        </div>
                        <p><strong>Note:</strong> All our seafood prices are based on the weight before cleaning or cutting. The
                            final weight at delivery will depend on the type of cut or preparation you select.</p>

                        <!-- Cutting Option Section -->
                        <form name="addtocart-form" method="post" action="{{ route('add.cart') }}">
                            @csrf
                            <div class="cutting-option mb-3">
                                <h4>Cutting Option<a href="#" id="openModalBtn" class="cutting-guide-link"
                                        style="margin-left: 10px;">Cutting Guide</a></h4>
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
                            <form method="POST" action="{{ route('wishlist.remove', ['id' => $product->id]) }}"
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
                                <input type="hidden" name="quantity" value="3">
                                <input type="hidden" name="image" value="{{ $product->image }}">
                                <input type="hidden" name="price" value="{{ $product->sale_price ?? $product->regular_price }}">
                                <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist"
                                    onclick="document.getElementById('wishlist-form').submit();">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-right: 6px;">
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
                                        $discount = round((($rproduct->regular_price - $rproduct->sale_price) / $rproduct->regular_price) * 100);
                                    }
                                @endphp

                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper position-relative">
                                        {{-- Discount Badge --}}
                                        @if($discount > 0)
                                            <div class="discount-badge"
                                                style="position:absolute; top:10px; left:10px; background:red; color:white; padding:5px 10px; font-weight:bold; border-radius:4px; z-index:5;">
                                                -{{ $discount }}%
                                            </div>
                                        @endif

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
                                                <span class="money price price-old text-muted" style="text-decoration: line-through;">
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
    <script>
        // ✅ 1. First initialize thumbnail slider with breakpoints
        var thumbnailSlider = new Swiper('.thumbnail-slider', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            mousewheel: true,

            breakpoints: {
                0: {
                    direction: 'horizontal',
                },
                768: {
                    direction: 'vertical',
                }
            }
        });

        // ✅ 2. Then initialize main slider and link it to the thumbnail slider
        var mainSlider = new Swiper('.main-slider', {
            spaceBetween: 5,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbnailSlider,
            },
        });

        // ✅ Modal functionality
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

        // ✅ Add to cart form validation
        document.getElementById("addtocart-form").addEventListener("submit", function (e) {
            let cuttingOption = document.getElementById("cutting_option").value;
            if (cuttingOption === "") {
                e.preventDefault();
                alert("⚠️ Please select a Cutting Option before adding to cart!");
            }
        });

        // ✅ Quantity controls
        document.addEventListener("DOMContentLoaded", function () {
            const qtyInput = document.querySelector(".qty-control__number");
            const btnIncrease = document.querySelector(".qty-control__increase");
            const btnDecrease = document.querySelector(".qty-control__reduce");

            btnIncrease.addEventListener("click", function () {
                let current = parseInt(qtyInput.value) || 3;
                qtyInput.value = current + 3;
            });

            btnDecrease.addEventListener("click", function () {
                let current = parseInt(qtyInput.value) || 3;
                if (current > 3) {
                    qtyInput.value = current - 3;
                } else {
                    qtyInput.value = 3;
                }
            });

            qtyInput.addEventListener("input", function () {
                let current = parseInt(qtyInput.value);
                if (isNaN(current) || current < 3) {
                    qtyInput.value = 3;
                }
            });
        });
    </script>


@endpush
