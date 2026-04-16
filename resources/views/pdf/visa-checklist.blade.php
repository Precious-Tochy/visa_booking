<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($visa_type ?? 'Visa') }} Visa Checklist</title>
    <style>
        /* General body */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #243F36;
            line-height: 1.6;
            margin: 40px;
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo img {
            height: 80px;
            border-radius: 12px;
        }

        /* Heading */
        h1 {
            color: #116682;
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        p.subtitle {
            text-align: center;
            color: #114f66;
            font-size: 1.1rem;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Section titles */
        h2 {
            color: #114f66;
            font-size: 1.5rem;
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
            margin-top: 30px;
        }

        /* Disclaimer */
        .disclaimer {
            font-size: 0.9rem;
            font-style: italic;
            color: #555;
            margin: 20px 0 30px 0;
            text-align: center;
        }

        /* Checklist items */
        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            background: #f0f8fa;
            padding: 12px 18px;
            margin-bottom: 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            font-size: 1rem;
        }

        li::before {
            content: '✔';
            color: #116682;
            font-weight: bold;
            margin-right: 8px;
        }

        /* Additional items */
        .extra {
            margin-top: 15px;
            background: #e6f0f0;
            padding: 15px 20px;
            border-radius: 12px;
        }

        .extra li::before {
            content: '➤';
            color: #114f66;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            font-size: 0.85rem;
            text-align: center;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        /* Page break for PDF */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <!-- Logo -->
    <div class="logo">
                    <img src="{{ public_path('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Tochy Travels Logo">
    </div>

    <!-- Title -->
    <h1>{{ ucfirst($visa_type ?? 'Visa') }} Visa Application Checklist</h1>
    <p class="subtitle">Guidance and Additional Tips for Your {{ ucfirst($visa_type ?? 'Visa') }} Visa</p>

    <!-- Disclaimer -->
    <p class="disclaimer">
        <em>Disclaimer: This checklist is for guidance only. Visa approval is made solely by the embassy or consulate.</em>
    </p>

    <!-- Main Checklist -->
    <h2>Main Checklist</h2>
    <ul>
        @foreach($checklist ?? [] as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>

    <!-- Additional Tips -->
    @if(!empty($additional ?? []))
        <h2>Additional Resources</h2>
        <ul class="extra">
            @foreach($additional as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Contact us: (+234) 905 353 1176 | Plot 140 Unity Estate 3-3 Onitsha, Anambra</p>
        <p>Professional Visa Assistance & Application Support</p>
    </div>

</body>
</html>
