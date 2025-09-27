<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>Surfside Media</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
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

    @stack('styles') <!-- For page-specific styles -->
</head>

<body>
    <!-- ✅ Loader -->
    <div id="loader-overlay">
        <div class="spinner">
            <div class="spinner1"></div>
        </div>
    </div>

    <!-- ✅ Top bar -->
    <div class="top-bar">
        <div class="top-bar-text">Welcome to IH SeaFood - Fresh & Healthy!</div>
    </div>

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
        $(function() {
            $("#search-input").on("keyup", function() {
                var searchQuery = $(this).val();
                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('user.search') }}",
                        data: {
                            query: searchQuery
                        },
                        dataType: 'json',
                        success: function(data) {
                            $("#box-content-search").html("");

                            if (data.length === 0) {
                                $("#box-content-search").append(`<li>No results found.</li>`);
                            }

                            $.each(data, function(index, item) {
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
                        error: function(xhr) {
                            console.log("Error: ", xhr.responseText);
                        }
                    });
                } else {
                    $("#box-content-search").html("");
                }
            });
        });
    </script>

    @stack('scripts') <!-- For page-specific scripts -->
</body>
</html>
