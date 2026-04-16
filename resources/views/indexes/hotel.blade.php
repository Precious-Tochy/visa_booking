@extends('layouts.index_layout')
@section('content')

<div class="background1">
      <h1 style="padding-top: 4rem;">Book Your Hotel Stay with Ease</h1>
    <i class="ri-arrow-down-line scroll-arrow"></i>
</div>

<div class="bookings">
    <h2>Hotel Reservations</h2>
    <h1>Contact Us</h1>
</div>

<div class="contact-container">
    

    <!-- Contact Info -->
    <div class="contact-info">
        <h4>How can we help you?</h4>
        <p><strong><i class="ri-phone-fill"></i></strong> (+234) 905 353 1176</p>
        <p><strong><i class="ri-map-pin-fill"></i></strong>Plot 140 Unity Estate 3-3 Onitsha, Anambra.</p>
        <iframe 
            src="https://www.google.com/maps?q=Plot+140+Unity+Estate+3-3+Onitsha,+Anambra&output=embed" 
            width="100%" height="800" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>

    <!-- Hotel Booking Form -->
    <div class="contact-form-container">
        <div class="service-intro">
    <h3 style="color: rgb(17,102,130); font-weight:700;">Our Hotel Reservation Services</h3>
    <p style="font-style: italic; color:rgb(36, 67, 36); font-size:14px;">
        We help you find the best hotels for your trip, from budget to luxury, and assist with check-in and booking confirmation.
    </p>
    <ul style="list-style-type: disc; padding-left: 20px; color:#243F36; font-size:14px;">
        <li>Domestic & International Hotels</li>
        <li>Luxury, 5-star, 4-star, 3-star Options</li>
        <li>Single, Double, Suite, Family Rooms</li>
        <li>Group & Corporate Bookings</li>
        <li>Special Requests (early check-in, meals, amenities)</li>
        <li>Hotel Recommendations & Best Rates</li>
    </ul>
</div>
<div class="how-it-works" style="margin-top:20px; margin-bottom:20px;">
    <h3 style="color: rgb(17,102,130); font-weight:700;">How Our Hotel Booking Works</h3>
    <ol style="padding-left: 20px; color:#243F36; font-size:14px;">
        <li>Submit your stay details using the form below.</li>
        <li>We search for the best hotels matching your preferences.</li>
        <li>Receive confirmation and pricing from our travel agent.</li>
        <li>Your reservation is booked and an e-ticket/confirmation is sent to you.</li>
    </ol>
</div>

        <form class="contact-form" method="POST" action="{{ route('hotel.book') }}" autocomplete="off">
            @csrf

            <!-- Guest Info -->
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

            <!-- Hotel Details -->
            <div class="row">
                <div class="form-group">
                    <h4>City / Country</h4>
                    <input type="text" name="location" required>
                </div>
                <div class="form-group">
                    <h4>Hotel Category</h4>
                    <select name="hotel_category" required>
                        <option value="">--Select--</option>
                        <option value="3-star">3 Star</option>
                        <option value="4-star">4 Star</option>
                        <option value="5-star">5 Star</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Check-in Date</h4>
                    <input type="date" name="check_in" required>
                </div>
                <div class="form-group">
                    <h4>Check-out Date</h4>
                    <input type="date" name="check_out" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Guests</h4>
                    <input type="number" name="guests" min="1" required>
                </div>
                <div class="form-group">
                    <h4>Rooms</h4>
                    <input type="number" name="rooms" min="1" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Room Type</h4>
                    <select name="room_type">
                        <option value="">--Select--</option>
                        <option value="standard">Standard</option>
                        <option value="deluxe">Deluxe</option>
                        <option value="suite">Suite</option>
                    </select>
                </div>
                <div class="form-group">
                    <h4>Preferred Hotel (optional)</h4>
                    <input type="text" name="preferred_hotel">
                </div>
            </div>

            <h4>Special Requests</h4>
            <textarea name="notes" placeholder="Airport pickup, breakfast, extra bed, etc"></textarea>

            <button type="submit">Submit Reservation</button>
        </form>
    </div>
</div>

<!-- Reset form when user clicks back -->
<script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            const form = document.querySelector('form.contact-form');
            if (form) form.reset(); // clears all input values
        }
    });
</script>

@endsection

<style>
/* Same styling as before; omitted here for brevity */
</style>


<style>
.background1{
    width: 100%;
    height: 100vh;
    background-image: url('{{ asset('visa-booking/image/Quer descobrir como comprar passagens aéreas….jpeg') }}');
    background-size: cover;
    background-position: center;
    position: relative;
}
.background1 h1{
    color: #ffffff;
    margin-top: 4rem;
    position: absolute;
    font-size: 6rem;
    text-align: center;
}
.scroll-arrow {
    font-size: 4.5rem;
    color: white;
    animation: bounceDown 0.9s infinite;
    position: absolute;
    top: 80%;
    left: 50%;
    transform: translate(-50%, -50%);
}
@keyframes bounceDown {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(12px); }
}
.bookings{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin-top: 2rem;
}
.bookings h2, .bookings h1 {
    font-weight: 600;
    color: rgb(17, 102, 130); 
    font-family: Georgia, 'Times New Roman', Times, serif;
}
.contact-container {
    display: flex;
    gap: 30px;
    padding: 20px;
    justify-content: center;
}
.contact-info {
    width: 25%;
    font-size: 14px;
    background-color: #f2f2f2;
    padding: 30px;
}
.contact-info h4{
    font-size: 1.52rem;
    margin-bottom:20px;
    font-weight: 650;
}
.contact-info i{
    font-size: 24px;
    padding-right: 5px;
}
.contact-form-container{
    background-color: #f2f2f2;
    padding: 30px;  
}
.contact-form {
    max-width: 700px;
}
.contact-form .row {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;  
}
.contact-form input,
.contact-form select,
.contact-form textarea {
    width: 100%;
    padding: 12px;
    font-size: 15px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
textarea {
    height: 120px;
}
button {
    padding: 10px 24px;
    background-color:rgb(17, 65, 82);
    color: white;
    border:1px solid rgb(17, 65, 82);
    cursor: pointer;
    font-size: 22px;
    font-weight: 650;
    border-radius:10px !important;
    font-family: Georgia, 'Times New Roman', Times, serif;
}
button:hover{
    background-color: rgb(17, 102, 130);
}
.row {
    display: flex;
    gap: 20px;
}
.form-group {
    display: flex;
    flex-direction: column; 
    flex: 1;
}
.form-group h4 {
    margin: 0 0 5px 0;
    font-size: 20px;
}
</style>
