@extends('layouts.index_layout')
@section('content')

<!-- Hero Section -->
<div class="background1">
    <h1>Explore The World With Our Guided Tours</h1>
    <i class="ri-arrow-down-line scroll-arrow"></i>
</div>

<!-- Header -->
<div class="bookings">
    <h2>Guided Tours</h2>
    <h1>Book Your Tour</h1>
</div>

<div class="contact-container">

    <!-- Contact Info -->
    <div class="contact-info">
        <h4>Need Help Planning Your Tour?</h4>
        <p><strong><i class="ri-phone-fill"></i></strong> (+234) 905 353 1176</p>
        <p><strong><i class="ri-map-pin-fill"></i></strong> Plot 140 Unity Estate 3-3 Onitsha, Anambra.</p>

        <iframe 
            src="https://www.google.com/maps?q=Plot+140+Unity+Estate+3-3+Onitsha,+Anambra&output=embed" 
            width="100%" height="800" style="border:0;" loading="lazy">
        </iframe>
    </div>

    <!-- Form -->
    <div class="contact-form-container">

        <!-- Services -->
        <div class="service-intro">
            <h3>Our Guided Tour Services</h3>
            <p>
                Discover amazing destinations with our professionally guided tours tailored to your travel needs.
            </p>
            <ul>
                <li>International & Local Tours</li>
                <li>City Sightseeing Packages</li>
                <li>Adventure & Safari Tours</li>
                <li>Luxury & Private Tours</li>
                <li>Group & Family Tours</li>
                <li>Cultural & Historical Experiences</li>
                <li>Hotel & Transportation Arrangements</li>
            </ul>
        </div>

        <!-- How it works -->
        <div class="how-it-works">
            <h3>How Our Tour Booking Works</h3>
            <ol>
                <li>Submit your tour request using the form below.</li>
                <li>We review your preferences.</li>
                <li>Receive the best tour packages.</li>
                <li>Confirm and we finalize your booking.</li>
            </ol>
        </div>

        <!-- Form -->
        <form class="contact-form" method="POST" action="{{ route('tour.book') }}">
            @csrf

            <div class="row">
                <div class="form-group">
                    <h4>First Name</h4>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <h4>Last Name</h4>
                    <input type="text" name="last_name" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Email</h4>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <h4>Phone</h4>
                    <input type="tel" name="phone" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Destination</h4>
                    <input type="text" name="country">
                </div>
                <div class="form-group">
                    <h4>Tour Type</h4>
                    <select name="package">
                        <option value="">--Select--</option>
                        <option value="city-tour">City Tour</option>
                        <option value="adventure">Adventure</option>
                        <option value="cultural">Cultural</option>
                        <option value="luxury">Luxury</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Travel Date</h4>
                    <input type="date" name="departure_date">
                </div>
                <div class="form-group">
                    <h4>Return Date</h4>
                    <input type="date" name="return_date">
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Travelers</h4>
                    <input type="number" name="travelers" min="1" value="1">
                </div>
                <div class="form-group">
                    <h4>Accommodation</h4>
                    <select name="hotel">
                        <option value="">--Select--</option>
                        <option value="3-star">3 Star</option>
                        <option value="4-star">4 Star</option>
                        <option value="5-star">5 Star</option>
                        <option value="luxury">Luxury</option>
                    </select>
                </div>
            </div>

           <div class="form-group full-width">
    <h4>Additional Requests</h4>
    <textarea name="notes" placeholder="Special requests, activities, preferences"></textarea>
</div>

<div class="form-group full-width">
    <button type="submit" class="submit-btn">Submit Tour Request</button>
</div>
        </form>

    </div>
</div>

@endsection

<style>
/* HERO */
.background1{
    width: 100%;
    height: 100vh;
    background-image: url('/visa-booking/image/been_to.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
}
.full-width{
    width: 100%;
}

/* Fix textarea spacing */
textarea{
    height: 120px;
    margin-bottom: 20px;
}

/* Fix button spacing */
.submit-btn{
    display: block;
    width: 100%;
    margin-top: 10px;
}

/* Optional: better spacing overall */
.contact-form{
    margin-top: 20px;
}
.background1 h1{
    color: #ffffff;
    position: absolute;
    top: 34%;
    width: 100%;
    text-align: center;
    font-size: 5rem;
    font-weight: 700;
}
.scroll-arrow {
    font-size: 4rem;
    color: white;
    animation: bounceDown 1s infinite;
    position: absolute;
    top: 80%;
    left: 50%;
    transform: translateX(-50%);
}
@keyframes bounceDown {
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(10px);}
}

/* HEADER */
.bookings{
    text-align: center;
    margin-top: 2rem;
}
.bookings h2, .bookings h1 {
    color: rgb(17,102,130);
}

/* LAYOUT */
.contact-container {
    display: flex;
    gap: 30px;
    padding: 30px;
}

/* CONTACT */
.contact-info {
    width: 30%;
    background: #f2f2f2;
    padding: 25px;
}
.contact-info h4{
    font-size: 1.5rem;
    margin-bottom: 20px;
}
.contact-info i{
    font-size: 20px;
}

/* FORM */
.contact-form-container{
    width: 65%;
    background: #f2f2f2;
    padding: 50px;
}
.contact-form .row{
    display: flex;
    gap: 15px;
}

.form-group{
    flex: 1;
    display: flex;
    flex-direction: column;
}
.form-group h4{
    margin-bottom: 5px;
}
input, select, textarea{
    padding: 10px;
    margin-bottom: 1.4rem !important;
    border: 1px solid #ccc;
}
textarea{
    height: 120px;
}

/* BUTTON */
button{
    padding: 12px 25px;
    background: rgb(17,65,82);
    color: #fff;
    border: none;
    font-size: 18px;
    border-radius: 8px;
    margin-top: 2rem;
}
button:hover{
    background: rgb(17,102,130);
}

/* SERVICES */
.service-intro h3,
.how-it-works h3{
    color: rgb(17,102,130);
}
.service-intro ul{
    padding-left: 20px;
}
.how-it-works{
    margin: 20px 0;
}

/* RESPONSIVE */
@media(max-width:900px){
    .contact-container{
        flex-direction: column;
    }
    .contact-info, .contact-form-container{
        width: 100%;
    }
}
</style>