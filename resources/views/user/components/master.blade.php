<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>IH SeaFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon"
        style="width: 100%; height: 100%;">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/plugins/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ✅ Fullscreen Loader Overlay */
        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/seafish.png') }}") no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            transition: opacity 0.9s ease;
        }

        /* Loader spinner */
        .spinner {
            /* background-image: linear-gradient(rgb(186, 66, 255) 35%, rgb(0, 225, 255)); */
            width: 100px;
            height: 100px;
            animation: spinning82341 1.7s linear infinite, hue 3s ease-in-out infinite;
            text-align: center;
            border-radius: 50px;
            filter: blur(1px);
            /* box-shadow: 0px -5px 20px 0px rgb(186, 66, 255), 0px 5px 20px 0px rgb(0, 225, 255); */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* fish image in center */
        .spinner1 {
            background: url("{{ asset('images/logo1.png') }}") no-repeat center center/contain;
            width: 100vh;
            height: 100vh;
            border-radius: 50%;
        }

        @keyframes spinning82341 {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes hue {
            0% {
                filter: hue-rotate(0deg);
            }

            100% {
                filter: hue-rotate(360deg);
            }
        }

        /* ✅ Top Bar */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: black;
            color: white;
            height: 30px;
            display: flex;
            align-items: center;
            overflow: hidden;
            z-index: 9999;
        }

        .top-bar-text {
            white-space: nowrap;
            display: inline-block;
            padding-left: 100%;
            animation: scrollText 15s linear infinite;
        }

        @keyframes scrollText {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* ✅ Mobile par loader ke waqt navbar & topbar hide karna */
        @media (max-width: 768px) {

            body.loading .top-bar,
            body.loading .navbar {
                display: none !important;
            }
        }

        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #25D366;
            color: white;
            border-radius: 50%;
            padding: 15px;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            background: #1ebe5d;
        }

        /* Tooltip bubble */
        .chat-tooltip {
            position: absolute;
            right: 70px;
            /* icon se thoda door */
            bottom: 50%;
            transform: translateY(50%);
            background: #25D366;
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Show on hover */
        .whatsapp-float:hover .chat-tooltip {
            opacity: 1;
            visibility: visible;
            right: 60px;
            /* thoda smooth slide effect */
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- ✅ Loader -->
    <div id="loader-overlay">
        <div class="spinner">
            <div class="spinner1"></div>
        </div>
    </div>
    <a href="https://wa.me/+923231449519" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
        <span class="chat-tooltip">Chat Now</span>
    </a>


    @yield('content')

    <!-- JavaScript Files -->
    <script src="{{ asset('js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/countdown.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="{{ asset('js/theme.js') }}"></script>

    <script>
        $(function () {
            $("#search-input").on("keyup", function () {
                var searchQuery = $(this).val();
                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('user.search') }}",
                        data: {
                            query: searchQuery
                        },
                        dataType: 'json',
                        success: function (data) {
                            $("#box-content-search").html("");

                            if (data.length === 0) {
                                $("#box-content-search").append(`<li>No results found.</li>`);
                            }

                            $.each(data, function (index, item) {
                                var url =
                                    "{{ route('detailpage', ['product_slug' => 'product_slug_pls']) }}";
                                var link = url.replace('product_slug_pls', item.slug);

                                $("#box-content-search").append(`
                                <li class="product-item gap14 mb-10">
                                    <div class="image no-bg">
                                        <img src="{{ asset('uploads/product') }}/${item.image}" alt="${item.name}">
                                    </div>
                                    <div class="flex items-center justify-between gap20 flex-grow">
                                        <div class="name">
                                            <a href="${link}" class="body-text">${item.name}</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-10">
                                    <div class="divider"></div>
                                </li>
                            `);
                            });
                        },
                        error: function (xhr) {
                            console.log("Error: ", xhr.responseText);
                        }
                    });
                } else {
                    $("#box-content-search").html("");
                }
            });
        });
        // ✅ loader ke waqt body me class add karna
        document.body.classList.add("loading");

        window.addEventListener("load", function () {
            const loader = document.getElementById("loader-overlay");
            loader.style.opacity = "0";

            setTimeout(() => {
                loader.style.display = "none";

                // ✅ loader hatne ke baad class remove
                document.body.classList.remove("loading");
            }, 500);
        });
    </script>
    @stack('scripts')
</body>

</html>
