@extends('layouts.index_layout')
@section('content')

<div class="background1">
    <h1>To proceed with the Booking, Kindly complete the Form Below</h1>
    <i class="ri-arrow-down-line scroll-arrow"></i>
</div>

<div class="bookings">
    <h2>Flight Booking</h2>
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

    <!-- Flight Booking Form + Services -->
    <div class="contact-form-container">

        <!-- What We Offer Section -->
        <div class="service-intro">
            <h3 style="color: rgb(17,102,130); font-weight:700; margin-bottom:10px;">Our Flight Booking Services</h3>
            <p style="font-style: italic; color:rgb(36, 67, 36); font-size:14px;">
                We provide fast, reliable, and affordable flight booking services for both domestic and international destinations. <br>
                Submit your travel details below and our travel consultants will contact you with the best available options.
            </p>

            <ul style="list-style-type: disc; padding-left: 20px; margin-top: 10px; color:#243F36; font-size:14px;">
                <li>Domestic & International Flights</li>
                <li>One-Way, Round-Trip & Multi-City Tickets</li>
                <li>Economy, Business & First Class Options</li>
                <li>Best Fare Deals & Airline Options</li>
                <li>Group & Family Bookings</li>
                <li>Student & Business Travel Assistance</li>
                <li>Ticket Changes & Re-Issuance Support</li>
                <li>Special Requests Handling (meals, wheelchair, seat preference)</li>
            </ul>
        </div>

        <!-- How It Works Section -->
        <div class="how-it-works" style="margin-top:20px; margin-bottom:20px;">
            <h3 style="color: rgb(17,102,130); font-weight:700; margin-bottom:10px;">How Our Flight Booking Works</h3>
            <ol style="padding-left: 20px; color:#243F36; font-size:14px;">
                <li><strong>Submit Your Travel Details:</strong> Fill in your passenger and travel information using the form below.</li>
                <li><strong>We Search & Compare Flights:</strong> Our agents check the best airline options and fares for you.</li>
                <li><strong>Confirmation & Payment:</strong> We contact you with available options and pricing.</li>
                <li><strong>Ticket Issuance:</strong> Once confirmed, your e-ticket is issued and sent to you.</li>
            </ol>
        </div>

        <!-- Flight Booking Form -->
        <form class="contact-form" method="POST" action="{{route('flight.book')}}">
            @csrf

            <!-- Passenger Info -->
            <div class="row">
                <div class="form-group">
                    <h4>First Name</h4>
                    <input type="text" name="first_name" required />
                </div>
                <div class="form-group">
                    <h4>Last Name</h4>
                    <input type="text" name="last_name" required />
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Email</h4>
                    <input type="email" name="email" required />
                </div>
                <div class="form-group">
                    <h4>Phone Number</h4>
                    <input type="tel" name="phone" required />
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Date of Birth</h4>
                    <input type="date" name="dob" />
                </div>
                <div class="form-group">
                    <h4>Passport Number</h4>
                    <input type="text" name="passport_number" />
                </div>
            </div>

            <!-- Flight Details -->
            <div class="row">
                <div class="form-group">
                    <h4>Departure City / Airport</h4>
                    <input type="text" name="departure_city" required />
                </div>
                <div class="form-group">
                    <h4>Destination City / Airport</h4>
                    <input type="text" name="destination_city" required />
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Departure Date</h4>
                    <input type="date" name="departure_date" required />
                </div>
                <div class="form-group">
                    <h4>Return Date (optional)</h4>
                    <input type="date" name="return_date" />
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Trip Type</h4>
                    <select name="trip_type" required>
                        <option value="">--Select--</option>
                        <option value="one-way">One-way</option>
                        <option value="round-trip">Round-trip</option>
                        <option value="multi-city">Multi-city</option>
                    </select>
                </div>
                <div class="form-group">
                    <h4>Number of Passengers</h4>
                    <input type="number" name="passengers" min="1" value="1" required />
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Class</h4>
                    <select name="class" required>
                        <option value="">--Select Class--</option>
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                        <option value="first">First Class</option>
                    </select>
                </div>
                <div class="form-group">
                    <h4>Preferred Airline (optional)</h4>
                    <input type="text" name="airline" />
                </div>
            </div>

            <!-- Special Requests -->
            <h4>Special Requests / Notes</h4>
            <textarea name="notes" placeholder="E.g., wheelchair assistance, meal preference"></textarea>

            <!-- Submit -->
            <button type="submit">Submit Booking</button>
        </form>
    </div>
</div>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success') && session('booking'))
<script>
    const booking = @json(session('booking'));
    const passengerName = booking.name;

    Swal.fire({
        title: '✈️ Booking Received!',
        html: `
            <p style="font-size:1.2rem; margin-bottom:10px;">
                Thank you for booking with <strong>Tochy Travels</strong>, <strong>${passengerName}</strong>!
            </p>
            <p style="margin-bottom:10px;">Your flight booking request has been successfully submitted. Our travel agent will contact you shortly.</p>
            <p style="font-weight:600; margin-top:10px;">Booking Summary:</p>
            <ul style="text-align:left; padding-left:20px;">
                <li>From: ${booking.departure_city}</li>
                <li>To: ${booking.destination_city}</li>
                <li>Departure: ${booking.departure_date}</li>
                <li>Return: ${booking.return_date || 'N/A'}</li>
                <li>Trip Type: ${booking.trip_type}</li>
                <li>Passengers: ${booking.passengers}</li>
                <li>Class: ${booking.class}</li>
                <li>Airline: ${booking.airline || 'N/A'}</li>
                <li>Notes: ${booking.notes || 'None'}</li>
            </ul>
        `,
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Print Booking',
        cancelButtonText: 'Close',
        confirmButtonColor: 'rgb(17,102,130)',
        cancelButtonColor: '#999',
    }).then((result) => {
        if (result.isConfirmed) {
            const printContent = `
                <html>
                <head>
                    <title>Tochy Travels - Booking Confirmation</title>
                    <style>
                        body { font-family: Arial, sans-serif; color:#000; padding: 20px; background:#fff; }
                        .header { text-align:center; margin-bottom:20px; }
                        .header img { width: 150px; margin-bottom: 10px; }
                        h2 { color: rgb(17, 102, 130); margin-bottom:5px; }
                        table { width:100%; border-collapse: collapse; margin-top:20px; }
                        th, td { border:1px solid rgb(17, 102, 130); padding:10px; text-align:left; }
                        th { background-color: rgb(17, 102, 130); color:#fff; }
                        p { margin:5px 0; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <img src="{{ url('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Tochy Travels Logo" />
                        <h2>Flight Booking Confirmation</h2>
                        <p>Thank you for booking with Tochy Travels!</p>
                    </div>
                    <table>
                        <tr><th>Passenger</th><td>${passengerName}</td></tr>
                        <tr><th>From</th><td>${booking.departure_city}</td></tr>
                        <tr><th>To</th><td>${booking.destination_city}</td></tr>
                        <tr><th>Departure</th><td>${booking.departure_date}</td></tr>
                        <tr><th>Return</th><td>${booking.return_date || 'N/A'}</td></tr>
                        <tr><th>Trip Type</th><td>${booking.trip_type}</td></tr>
                        <tr><th>Passengers</th><td>${booking.passengers}</td></tr>
                        <tr><th>Class</th><td>${booking.class}</td></tr>
                        <tr><th>Airline</th><td>${booking.airline || 'N/A'}</td></tr>
                        <tr><th>Notes</th><td>${booking.notes || 'None'}</td></tr>
                    </table>
                    <p style="margin-top:20px;">Please keep this confirmation for your records. Our travel agent will contact you shortly with flight options.</p>
                </body>
                </html>
            `;
            const w = window.open('', '', 'height=700,width=900');
            w.document.write(printContent);
            w.document.close();
            w.print();
        }
    });
</script>
@endif

@endsection

<!-- CSS -->
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
    text-align: center;
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
.bookings h2{
    font-size: 2.2rem;
}
.contact-container {
    display: flex;
    gap: 30px;
    padding: 20px;
    display: flex;
    justify-content: center;
    
    flex-direction: row; 
}
.contact-info {
    width: 25%;
    font-size: 14px;
    background-color: #f2f2f2;
    padding: 30px;
    box-sizing: border-box;
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
    box-sizing: border-box;  
    
}
.contact-form {
    max-width: 700px;
}
.contact-info p{
    font-size: 17px;
    font-weight: 500;
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
.contact-form select{
    font-size: 16px;
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
.form-group input{
  width: 300px;
}
</style>
