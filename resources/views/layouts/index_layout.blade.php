<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa Booking</title>
    <link rel="stylesheet" href="{{ asset('visa-booking/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('visa-booking/css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet" />


</head>

<body>
@include('sweetalert::alert')
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid my-navbar">
            <a class="navbar-brand" href="{{ url('/') }}"><img
                    src="{{ asset('visa-booking/image/logo_tochy_travels.jpg') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item shimmer-once">
                        <a class="nav-link " aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link" href="{{ url('/#about') }}">About Us</a>
</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#service') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ url('/#destination') }}">Destination</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#testimonial') }}">Testimonials</a>
                    </li>
                </ul>
            </div>

    </nav>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.my-navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    @yield('content')

    <div class="footer">
        <div class="footer-cover">
            <div class="icon">
                <img src="{{ asset('visa-booking/image/logo_tochy_travels.jpg') }}" alt="">
                <p>Tochy on a journey of unparalleled adventure with our travel agency, where every detail is curated to
                    perfection, ensuring you not only explore the world.</p>
                <div class="footer-socials">
                    <a href=""><i class="ri-facebook-fill"></i></a>
                    <a href=""><i class="ri-instagram-line"></i></a>
                    <a href=""><i class="ri-twitter-x-line"></i></a>
                    <a href=""><i class="ri-whatsapp-line"></i></a>
                </div>
                <a href="" class="footer-link">Refund and Cancellation Policy</a>
            </div>
            <div class="let-talk">
                <h1>Let's <br> Talk</h1>
                <div class="glo">
                    <div class="info-box">
                        <h3>For more info: </h3><a href="mailto:booking@tochy.com">booking@tochy.com</a>
                    </div>
                    <div class="info-box">
                        <h3>Contact us Now: </h3><a href="tel:+2349053531176">(+234) 905 353 1176</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-line"></div>
        <h6>@2025 Tochy Travel All Rights Reserved</h6>
    </div>
    <button id="scrollTopBtn">
        <i class="ri-arrow-up-line"></i>
    </button>
    <script>
        const topBtn = document.getElementById("scrollTopBtn");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                topBtn.classList.add("show");
            } else {
                topBtn.classList.remove("show");
            }
        });

        topBtn.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>

    <script>
        /* ---- Auto-shimmer when a section enters view (works with your current divs) ---- */

        const navLinks = document.querySelectorAll('.nav-link'); // <a href="#about"> etc
        const navItems = document.querySelectorAll('.nav-item');

        // build array of actual section elements based on the nav links' hrefs
        const sections = Array.from(navLinks)
            .map(link => document.querySelector(link.getAttribute('href')))
            .filter(Boolean); // remove nulls if any href doesn't match an element

        // If no sections found, exit early to avoid errors
        if (sections.length === 0) {
            console.warn('No sections found for nav links — check your href / id values.');
        } else {
            const observerOptions = {
                threshold: 0.5, // when ~50% of the section is visible
                rootMargin: '0px 0px -20% 0px' // shift trigger slightly up for nicer UX
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (!entry.target || !entry.target.id) return;

                    if (entry.isIntersecting) {
                        const id = entry.target.id;

                        navItems.forEach(item => {
                            const link = item.querySelector('a');
                            if (!link) return;

                            if (link.getAttribute('href') === `#${id}`) {
                                // make this item active
                                item.classList.add('active');

                                // play shimmer once
                                item.classList.add('shimmer');
                                // remove shimmer after animation length (match to your CSS)
                                setTimeout(() => item.classList.remove('shimmer'), 1000);
                            } else {
                                // remove active from other items
                                item.classList.remove('active');
                            }
                        });
                    }
                });
            }, observerOptions);

            // Observe each section
            sections.forEach(s => observer.observe(s));
        }
    </script>

</body>
<script src="{{ asset('visa booking/js/bootstrap.bundle.js') }}"></script>

</html>
