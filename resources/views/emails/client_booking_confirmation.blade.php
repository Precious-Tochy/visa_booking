<h2>Hello {{ $name }},</h2>
<p>Thank you for booking your flight with <strong>Tochy Travels</strong>.</p>
<ul>
    <li><strong>Departure:</strong> {{ $departure_city }}</li>
    <li><strong>Destination:</strong> {{ $destination_city }}</li>
    <li><strong>Departure Date:</strong> {{ $departure_date }}</li>
    <li><strong>Return Date:</strong> {{ $return_date }}</li>
    <li><strong>Trip Type:</strong> {{ $trip_type }}</li>
    <li><strong>Passengers:</strong> {{ $passengers }}</li>
    <li><strong>Class:</strong> {{ $class }}</li>
    <li><strong>Airline:</strong> {{ $airline }}</li>
    <li><strong>Notes:</strong> {{ $notes }}</li>
</ul>
<p>Our travel agent will contact you shortly with flight options and payment instructions.</p>
<p>Thank you for choosing Tochy Travels!</p>
