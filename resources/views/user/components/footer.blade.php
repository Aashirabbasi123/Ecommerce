<style>
    .footer {
        background-color: #0077b6;
        /* Ocean Blue shade */
        color: #ffffff;
        /* White text for contrast */
    }

    .footer a {
        color: #ffffff;
        /* Links bhi white hon */
        transition: color 0.3s ease;
    }

    .footer a:hover {
        color: #90e0ef;
        /* Hover par halka aqua blue */
    }

    .footer .social-links svg {
        fill: #ffffff;
        /* Social icons white */
        transition: fill 0.3s ease;
    }

    .footer .social-links svg:hover {
        fill: #90e0ef;
        /* Hover par aqua effect */
    }
</style>
<hr class="mt-5 text-secondary" />
<footer class="footer footer_type_2">
    <div class="footer-middle container">
        <div class="row row-cols-lg-5 row-cols-2">
            <div class="footer-column footer-store-info col-12 mb-4 mb-lg-0">
                <div class="logo">
                    <a href="{{route('dashboard')}}">
                        <img src="{{ asset('images/logo.png') }}" alt="Ih SeaFood" class="logo__image d-block" />
                    </a>
                </div>
                <p class="footer-address">123 Beach Avenue, Surfside City, CA 00000</p>
                <p class="m-0"><strong class="fw-medium">info.ihseafood@gmail.com</strong></p>
                <p><strong class="fw-medium">+92 3231449519</strong></p>

                <ul class="social-links list-unstyled d-flex flex-wrap mb-0">
                    <li>
                        <a href="https://www.facebook.com/share/16RK3VjbgF/" class="footer__social-link d-block">
                            <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_facebook" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/ih_seafoods?igsh=cGw0ang4Z21zdjB2" class="footer__social-link d-block">
                            <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_instagram" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Company</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="{{route('dashboard')}}" class="menu-link menu-link_us-s">Home</a></li>
                    <li class="sub-menu__item"><a href="{{ route('about') }}" class="menu-link menu-link_us-s">About Us</a></li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">Shop</a></li>
                    <li class="sub-menu__item"><a href="{{route('contact')}}" class="menu-link menu-link_us-s">Contact Us</a>
                    </li>
                </ul>
            </div>

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Shop</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">New
                            Arrivals</a>
                    </li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}"
                            class="menu-link menu-link_us-s">Accessories</a>
                    </li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">Fish</a>
                    </li>
                    <li class="sub-menu__item"><a href="{{ route('shop') }}" class="menu-link menu-link_us-s">Shop
                            All</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container d-md-flex align-items-center">
            <span class="footer-copyright me-auto">©2024 Ih SeaFood</span>
            <div class="footer-settings d-md-flex align-items-center">
                <a href="#">Privacy Policy</a> &nbsp;|&nbsp; <a href="#">Terms &amp;
                    Conditions</a>
            </div>
        </div>
    </div>
</footer>
