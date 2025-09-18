@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">About Us</h2>
            </div>

            <div class="about-us__content pb-5 mb-5">
                <p class="mb-5">
                    <img loading="lazy" class="w-100 h-auto d-block" src="images/about/about.jpg" width="1410" height="550"
                        alt="Fresh Seafood" />
                </p>
                <div class="mw-930">
                    <h3 class="mb-4">OUR STORY</h3>
                    <p class="fs-6 fw-medium mb-4">
                        At <strong>Seafood Delight</strong>, we believe that the ocean is nature’s greatest gift.
                        Our journey began with a simple idea — to bring the freshest, healthiest, and most delicious
                        seafood directly from the shore to your plate. From local fishermen to modern storage and
                        delivery methods, we ensure that every product you receive is rich in quality, taste,
                        and nutrition.
                    </p>
                    <p class="mb-4">
                        Seafood is more than just food; it’s a lifestyle of healthy living. Packed with omega-3 fatty
                        acids, vitamins, and essential nutrients, our seafood products are carefully selected to support
                        your wellness while offering unmatched flavor. Whether it’s juicy prawns, tender fish, or
                        premium shellfish, we guarantee freshness and authenticity in every bite.
                    </p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="mb-3">Our Mission</h5>
                            <p class="mb-3">
                                To deliver fresh, sustainable, and high-quality seafood to our customers while supporting
                                local fishermen and promoting healthy eating habits across communities.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Our Vision</h5>
                            <p class="mb-3">
                                To become the most trusted seafood brand by ensuring freshness, innovation, and excellence
                                — making seafood a part of every household’s daily nutrition.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mw-930 d-lg-flex align-items-lg-center">
                    <div class="image-wrapper col-lg-6">
                        <img class="h-auto" loading="lazy" src="images/about/about.jpg" width="450" height="500"
                            alt="Seafood Company">
                    </div>
                    <div class="content-wrapper col-lg-6 px-lg-4">
                        <h5 class="mb-3">The Company</h5>
                        <p>
                            We are more than just a seafood supplier — we are passionate ocean lovers,
                            quality keepers, and health promoters. With years of expertise in the seafood
                            industry, we have built strong relationships with trusted fishermen and farms,
                            allowing us to provide premium products at affordable prices. Every step, from
                            sourcing to packaging, is done with care to maintain the natural freshness of
                            the sea.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('user.components.footer')
@endsection
