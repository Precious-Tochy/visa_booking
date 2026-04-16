<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visa Booking</title>
   
    <link rel="stylesheet" href="{{asset('visa-booking/css/bootstrap.min.css')}}">
     <link rel="stylesheet" href="{{asset('visa-booking/css/index.css')}}">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css"
    rel="stylesheet"
/>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
/>

    
</head>
<body>
    <!-- ================= LUXURY PRELOADER ================= -->
<!-- ================= LUXURY PRELOADER ================= -->
<div id="preloader">
    <div class="lux-loader">
        <div class="orbit">
            <div class="plane">✈</div>
        </div>

        <h2 class="brand-name">Tochy Travels</h2>
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
    </div>
</div>
  <div class="background" id="home">
 <nav class="navbar navbar-expand-lg">
  <div class="container-fluid my-navbar">
    <a class="navbar-brand" href="#"><img src="{{asset('visa-booking/image/logo_tochy_travels.jpg')}}" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav" >
      <ul class="navbar-nav">
        <li class="nav-item shimmer-once">
          <a class="nav-link " aria-current="page" href="#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#service">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#destination">Destination</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#testimonial">Testimonials</a>
        </li>
        </ul>
    </div>
     </div>
</nav>


<h1>Seamless visa solutions</h1>
<p>WORLDWIDE</p>
    
  </div>
    
  <div class="about-us" id="about">
    <img src="{{asset('visa-booking/image/Get your Schengen travel visa with ease! Visit….jpeg')}}" alt="">
    <div class="about">
      <h2 >About us </h2>
      <p>

Tochy Limited is a trusted visa facilitation and travel support company dedicated to providing  a seamless, transparent, and professional visa application experience. We specialize in assisting clients with visa processing for Japan, South Africa, Canada, Gambia, the United States, the  United Kingdom, Kenya, and Algeria, offering clear guidance and reliable support throughout  every stage of the process.
At Tochy Limited, we understand that visa applications can be  complex and time-sensitive. Our team combines industry expertise with secure digital systems to ensure  that every application is handled with accuracy, confidentiality, and efficiency. From tourism and business travel to study, employment, and family visits, we deliver well-structured assistance designed to meet each country’s specific requirements.

We pride ourselves on professionalism, integrity, and exceptional client service. With timely updates, personalized support, and a commitment to excellence.


</p>
    </div>
  </div>
<div class="services" id="service">
<h2>Our Services</h2>
<div class="real-services">
    <div class="real-info">
    <img src="{{asset('visa-booking/image/The solo traveler says the woman ‘scoffed….jpeg')}}" alt="">
    <div class="line"></div>
   <a href="{{route('flight_booking')}}">Flight Booking</a> 
    

</div>
 <div class="real-info">
    <img src="{{asset('visa-booking/image/Imagem de hotel, inspiração para criar um hotel….jpeg')}}" alt="">
    <div class="line"></div>
    <a href="{{ route('hotel_booking') }}">Hotel Reservations</a>
</div>
 

<div class="real-info">
    <img src="{{ asset('visa-booking/image/In a bid to enhance international travel….jpeg') }}" alt="">
    <div class="line"></div>
    <a href="{{ route('visa.form') }}">VISA Assistance</a>
</div>

 <div class="real-info">
    <img src="{{asset('visa-booking/image/BYD Car Description BYD, which stands for _Build….jpeg')}}" alt="">
    <div class="line"></div>
    <a href="{{ route('car.rentals') }}">Car Rental</a>
    

</div>
 <div class="real-info">
    <img src="{{asset('visa-booking/image/Wenn du dich auf eine Wanderung begibst, sei es… (1).jpeg')}}" alt="">
    <div class="line"></div>
    <a href="{{route('tour.form')}}">Guided Tour</a>
    

</div>
 <div class="real-info">
    <img src="{{asset('visa-booking/image/Packing Tips You\'ll Want for Your Next Trip….jpeg')}}" alt="">
    <div class="line"></div>
    <a href="{{ route('packages.index') }}">Tour Package</a>
    </div>
</div>
</div>

<div class="country-packages">
    <h2>Popular Travel Packages</h2>
    <p class="subtitle">Carefully selected packages for top destinations</p>
     
    <!-- Filter Buttons -->
    <div class="filter-buttons">
    <a href="#" class="active" data-country="">All</a>

    @foreach($countries as $country)
        <a href="#" data-country="{{ $country }}">{{ $country }}</a>
    @endforeach
</div>

    <!-- Packages Grid -->
    <div class="packages-grid" id="packagesContainer">
    @include('indexes.partials.packages')


        

    </div>
</div>
</div>

<div class="destinations" id="destination">
<h2>Destinations</h2>
<h1>Embark on Scenic Adventures</h1>
</div>
<div class="carousel-wrapper">
      <button class="prev">&#10094;</button>


<div class="carousel">
  <div class="carousel-track">
    <div class="slide"><img src="{{asset('visa-booking/image/Dive into the mesmerizing attractions only in….jpeg')}}"></div>
    
    <div class="slide">
     <p>

Discover a world filled with breathtaking destinations, vibrant cultures, and unforgettable experiences. Whether you’re planning a relaxing holiday, an adventure-packed trip, or a business journey, we make it easy for you to explore beautiful places with confidence.

Our platform connects you to stunning locations across the globe—from modern, bustling cities to peaceful tropical escapes and rich historical landmarks. Each destination offers something unique, allowing you to enjoy the perfect blend of nature, culture, and lifestyle.

For travelers seeking a touch of luxury, we also highlight premium destinations designed to deliver elegance, comfort, and extraordinary moments. From serene islands to iconic attractions, every journey is crafted to leave you with memories that last a lifetime.

Start your adventure today.
Travel smarter, travel better, and explore the world’s most beautiful places—one destination at a time.

</p>
    
    <img src="/image/Discover my latest Canva poster design created for….jpeg"></div>

  <div class="slide"><img src="{{asset('visa-booking/image/As a travel blogger, that is just too f-ing….jpeg')}}"></div>
  </div>
  </div>
  
<button class="next">&#10095;</button>

</div>

<div class="reasons">
<div class="reason">
    <img src="{{asset('visa-booking/image/🗽✨ Step into the vibrant heart of New York City….jpeg')}}" alt=""></div>
    <div class="reason-two">
    <img src="{{asset('visa-booking/image/Pricing plans _ Freepik.jpeg')}}" alt="">
    </div>
    
    <div class="tochy-ltd">
<h1>Why Choose Tochy Travel Agency</h1>
<p>At Tochy Travel Agency, we make your travel dreams a reality. Specializing in visa bookings, we simplify the process so you can focus on planning your journey, not the paperwork. With years of experience and a deep understanding of international travel regulations, we provide fast, reliable, and hassle-free visa services for countries across the globe.

We pride ourselves on:

Expert Guidance: Our team guides you through every step of the visa application process, ensuring all your documents are complete and accurate.

Trusted & Reliable: We have successfully assisted countless travelers in securing visas, building a reputation for efficiency and trust.

Wide Coverage: Whether you’re traveling for business, study, or leisure, we help you secure visas for multiple destinations, including Japan, South Africa, Congo, Gambia, USA, UK, Kenya, and Algeria.

Personalized Service: Every traveler is unique. We provide tailored support to match your specific travel needs and timelines.

Peace of Mind: Avoid delays, errors, and rejections with our expert support and guidance at every stage.

Choose Tochy Travel Agency and experience a seamless visa booking service that makes your journey smoother, faster, and stress-free. Your adventure starts with confidence — let us take care of the rest.</p>
<a href="#service"><button class="btn2">Book Now <i class="ri-bookmark-line"></i></button></a>
</div>
    </div>
  

    <div class="client" id="testimonial">
<h1>What Our Clients Say</h1></div>
<div class="box-holder" id="testimonial-carousel">
<div class="box-client">
  <h4>Happiness A.</h4>
  <p><i class="ri-double-quotes-l"></i>Tochy Travels Limited made my visa application incredibly smooth. I was worried about missing documents, but their team guided me step-by-step and handled everything professionally. My visa was approved faster than I expected. I highly recommend them for anyone looking for a stress-free process!<i class="ri-double-quotes-r"></i></p>

</div>
<div class="box-client">
  <h4>Emelie S.</h4>
  <p><i class="ri-double-quotes-l"></i>I’ve used other travel agencies before, but none compare to Tochy Travels Limited. Their customer service is outstanding. They answered all my questions, kept me updated, and made sure I understood every requirement. Thanks to them, I had no issues securing my UK visa.<i class="ri-double-quotes-r"></i></p>

</div>
<div class="box-client">
  <h4>Dindu E.</h4>
  <p><i class="ri-double-quotes-l"></i>A friend recommended Tochy Travels Limited, and it turned out to be the best decision. They handled my Japan visa with total professionalism. No delays, no errors—just a smooth and trustworthy service. I will definitely use them again for my future travels <i class="ri-double-quotes-r"></i></p>

</div>
    </div>
    
    
 
  <div class="footer">
   <div class="footer-cover">
    <div class="icon">
    <img src="{{asset('visa-booking/image/logo_tochy_travels.jpg')}}" alt="">
    <p>Tochy on a journey of unparalleled adventure with our travel agency, where every detail is curated to perfection, ensuring you not only explore the world.</p>
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
<h3>For more info: </h3><a href="mailto:booking@tochy.com">booking@tochy.com</a></div>
<div class="info-box">
<h3>Contact us Now: </h3><a href="tel:+2349053531176">(+234) 905 353 1176</a></div>
</div>
  </div></div>
  <div class="footer-line"></div>
  <h6>@2025 Tochy Travel All Rights Reserved</h6>
  </div>
<button id="scrollTopBtn">
    <i class="ri-arrow-up-line"></i>
</button>



<!-- Chat Launcher (icon-only bubble) -->
<div id="visa-chat-launcher">
 
    <i class="ri-customer-service-2-line help-icon"></i>
</div>


<!-- Chat Panel -->
<div id="visa-chat-panel">
    <div class="visa-chat-header">
        <div>
            <h4>Visa Assistance Desk</h4>
            <p>Official Support Channel</p>
        </div>
        <button id="visa-chat-close">&times;</button>
    </div>

    <div class="visa-chat-body" id="visaChatBody">
        <div class="visa-msg system">
            Welcome to our Visa Assistance Platform.<br><br>
            Our consultants can help you with:
            <ul>
                <li>Tourist & Visit Visas</li>
                <li>Student & Study Abroad Visas</li>
                <li>Work & Business Visas</li>
                <li>Appointment Booking & Documentation</li>
            </ul>
            Please select an option below to proceed.
        </div>

        <div class="quick-options">
            <button data-msg="Tourist Visa">Tourist Visa</button>
            <button data-msg="Student Visa">Student Visa</button>
            <button data-msg="Work Visa">Work Visa</button>
            <button data-msg="Visa Pricing">Visa Pricing</button>
        </div>
    </div>

    <div class="visa-chat-footer">
        <input type="text" id="visaChatInput" placeholder="Type your message here...">
        <button id="visaChatSend">
    <i class="ri-send-plane-2-line"></i>
</button>

    </div>
</div>


<!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Your custom JS (must come LAST) -->
    <script src="{{asset('visa-booking/js/index.js')}}"></script>

</body>
</html>