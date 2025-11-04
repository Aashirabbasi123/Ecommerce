<style>
    .footer {
        background-color: #0077b6;
        color: #ffffff;
        padding: 40px 0 0;
    }

    .footer a {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer a:hover {
        color: #90e0ef;
    }

    .footer .social-links svg {
        fill: #ffffff;
        transition: fill 0.3s ease;
    }

    .footer .social-links svg:hover {
        fill: #90e0ef;
    }

    .qr-container {
        text-align: center;
        padding: 20px;
    }

    .qr-img {
        max-width: 100%;
        height: auto;
        width: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Contact info icons */
    .contact-info {
        margin-top: 15px;
    }

    .contact-info p {
        display: flex;
        align-items: center;
        margin: 8px 0;
        font-size: 14px;
    }

    .contact-info i {
        margin-right: 10px;
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    /* Footer headings */
    .sub-menu__title {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 16px;
    }

    .sub-menu__list {
        padding-left: 0;
    }

    .sub-menu__item {
        margin-bottom: 8px;
    }

    .menu-link {
        font-size: 14px;
        opacity: 0.9;
    }

    .menu-link:hover {
        opacity: 1;
    }

    /* Footer bottom */
    .footer-bottom {
        background-color: #005a87;
        padding: 20px 0;
        margin-top: 30px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    .footer-copyright {
        font-size: 14px;
        opacity: 0.9;
    }

    .footer-settings a {
        font-size: 14px;
        opacity: 0.9;
    }

    .footer-settings a:hover {
        opacity: 1;
    }

    /* Logo styling */
    .footer .logo__image {
        max-width: 150px;
        height: auto;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .footer {
            padding: 30px 0 0;
        }

        .qr-img {
            width: 150px;
        }

        .footer-column {
            margin-bottom: 25px !important;
        }

        .footer-bottom .container {
            text-align: center;
            flex-direction: column;
        }

        .footer-copyright {
            margin-bottom: 10px;
        }

        .contact-info p {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .footer .row {
            flex-direction: column;
        }

        .qr-container {
            order: -1;
            padding: 0 0 20px;
        }
    }
</style>

<hr class="mt-5 mb-0 text-secondary" />
<footer class="footer footer_type_2">
    <div class="footer-middle container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5">
            <!-- Company Info -->
            <div class="footer-column footer-store-info col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="logo mb-3">
                    <a href="{{route('dashboard')}}">
                        <img src="{{ asset('images/logo.png') }}" alt="Ih SeaFood" class="logo__image d-block" />
                    </a>
                </div>

                <div class="contact-info">
                    <p>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Karachi, Pakistan</span>
                    </p>
                    <p>
                        <i class="fas fa-envelope"></i>
                        <span>info.ihseafood@gmail.com</span>
                    </p>
                    <p>
                        <i class="fas fa-phone"></i>
                        <span>+92 3231449519</span>
                    </p>
                </div>

                <ul class="social-links list-unstyled d-flex mb-0 mt-3">
                    <li>
                        <a href="https://www.facebook.com/share/16RK3VjbgF/" class="footer__social-link d-block me-3" target="_blank">
                            <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_facebook" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/ih_seafoods?igsh=cGw0ang4Z21zdjB2"
                            class="footer__social-link d-block" target="_blank">
                            <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_instagram" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Company Links -->
            <div class="footer-column footer-menu col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Company</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="{{route('dashboard')}}" class="menu-link menu-link_us-s">Home</a></li>
                    <li class="sub-menu__item"><a href="{{ route('about') }}" class="menu-link menu-link_us-s">About Us</a></li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">Shop</a></li>
                    <li class="sub-menu__item"><a href="{{route('contact')}}" class="menu-link menu-link_us-s">Contact Us</a></li>
                </ul>
            </div>

            <!-- Shop Links -->
            <div class="footer-column footer-menu col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Shop</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">New Arrivals</a></li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">Accessories</a></li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">Fish</a></li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">Shop All</a></li>
                </ul>
            </div>

            <!-- QR Code -->
            <div class="footer-column qr-container col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Scan to Connect</h6>
                <img src="{{ asset('images/ihseafood_qr_code.png') }}" alt="QR Code" class="qr-img">
                <p class="mt-2" style="font-size: 12px; opacity: 0.8;">Scan QR code to visit our website</p>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container d-md-flex align-items-center justify-content-between">
            <span class="footer-copyright d-block mb-2 mb-md-0">© 2024 Ih SeaFood. All rights reserved.</span>
            <div class="footer-settings d-flex align-items-center">
                <a href="#" class="d-inline-block mx-2">Privacy Policy</a>
                <span class="text-white opacity-50">|</span>
                <a href="#" class="d-inline-block mx-2">Terms & Conditions</a>
            </div>
        </div>
    </div>
</footer>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
