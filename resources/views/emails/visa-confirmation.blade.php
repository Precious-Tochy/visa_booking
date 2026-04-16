<!DOCTYPE html>
<html>
<head>
    <title>Visa Request Confirmation</title>
</head>
<body>
    <h2>Hello {{ $visaRequest->first_name }},</h2>
    <p>Thank you for submitting your visa assistance request for a {{ ucfirst($visaRequest->visa_type) }} visa to {{ $visaRequest->country }}.</p>

    <h3>Your Personalized Document Checklist:</h3>
    <ul>
        @foreach($checklist as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>

    <p>Next Steps:</p>
    <ol>
        <li>Our consultant will review your submission.</li>
        <li>We will contact you via {{ $visaRequest->consultation ?? 'email' }} for guidance.</li>
        <li>You can access your dashboard and download additional resources.</li>
    </ol>

    <p><a href="{{ url('/visa-thankyou/'.$visaRequest->id) }}">Click here for next steps & resources</a></p>

    <p>Best Regards,<br>Visa Assistance Team</p>
</body>
</html>
