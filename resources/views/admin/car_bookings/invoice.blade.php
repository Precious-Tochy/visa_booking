<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Invoice #{{ $booking->booking_reference }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
                margin: 0;
            }
            
            .invoice-header {
                background: #114B66 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .status-badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .print-button {
                display: none;
            }
        }

        .invoice-container {
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 30px 50px rgba(17, 75, 102, 0.15);
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        /* Header */
        .invoice-header {
            background: #114B66;
            padding: 35px 45px;
            color: white;
            position: relative;
        }

        .invoice-header::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%);
            pointer-events: none;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
            flex-wrap: wrap;
            gap: 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            flex-shrink: 0;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .company-name h1 {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .company-name .tagline {
            font-size: 12px;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title .invoice-number {
            font-size: 14px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 20px;
            border-radius: 30px;
            display: inline-block;
            font-weight: 500;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .invoice-title h2 {
            font-size: 42px;
            font-weight: 200;
            margin-top: 10px;
            opacity: 0.95;
            letter-spacing: 3px;
        }

        .header-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
            flex-wrap: wrap;
            gap: 20px;
        }

        .status-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .status-label {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.7;
        }

        .status-badge {
            background: rgba(255,255,255,0.15);
            padding: 10px 25px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .status-badge.pending { background: #f39c12; color: white; }
        .status-badge.confirmed { background: #27ae60; color: white; }
        .status-badge.completed { background: #2980b9; color: white; }
        .status-badge.cancelled { background: #e74c3c; color: white; }

        .date-issued {
            font-size: 14px;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .date-issued strong {
            background: rgba(255,255,255,0.1);
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Content */
        .invoice-content {
            padding: 45px;
            background: white;
        }

        /* Section title */
        .section-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #114B66;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-left: 15px;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 20px;
            background: #114B66;
            border-radius: 3px;
        }

        /* Customer card */
        .customer-card {
            background: #f8faff;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 35px;
            border: 1px solid #e9ecf0;
        }

        .customer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
        }

        .customer-item .label {
            font-size: 11px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .customer-item .value {
            font-size: 16px;
            font-weight: 500;
            color: #2c3e50;
            word-break: break-word;
        }

        /* Booking grid */
        .booking-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .info-card {
            background: white;
            border: 1px solid #edf2f7;
            border-radius: 14px;
            padding: 20px;
            transition: all 0.2s;
            border-left: 3px solid #114B66;
            height: 100%;
        }

        .info-icon {
            font-size: 24px;
            margin-bottom: 12px;
            color: #114B66;
        }

        .info-label {
            font-size: 11px;
            color: #95a5a6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .info-sub {
            font-size: 12px;
            color: #7f8c8d;
            word-break: break-word;
        }

        /* Vehicle card */
        .vehicle-card {
            background: linear-gradient(135deg, #fafcff 0%, white 100%);
            border-radius: 18px;
            padding: 25px;
            margin-bottom: 35px;
            border: 1px solid #eef2f6;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .vehicle-image {
            width: 140px;
            height: 140px;
            border-radius: 16px;
            background: #f1f5f9;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(17, 75, 102, 0.1);
            flex-shrink: 0;
        }

        .vehicle-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vehicle-details {
            flex: 1;
            min-width: 250px;
        }

        .vehicle-name {
            font-size: 24px;
            font-weight: 700;
            color: #1a2634;
            margin-bottom: 10px;
            word-break: break-word;
        }

        .vehicle-specs {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .spec-tag {
            background: #f0f4f9;
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 13px;
            color: #114B66;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .vehicle-location {
            margin-top: 12px;
            font-size: 14px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 5px;
            word-break: break-word;
        }

        /* Price table */
        .price-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            border: 1px solid #eef2f6;
            box-shadow: 0 10px 25px rgba(17, 75, 102, 0.05);
        }

        .price-table {
            width: 100%;
            border-collapse: collapse;
        }

        .price-table tr td {
            padding: 15px 0;
            border-bottom: 1px solid #ecf1f7;
        }

        .price-table tr:last-child td {
            border-bottom: none;
        }

        .price-table td:first-child {
            color: #4a5b6e;
            font-weight: 400;
        }

        .price-table td:last-child {
            text-align: right;
            font-weight: 600;
            color: #1e293b;
        }

        .price-table .driver-row td {
            color: #114B66;
            font-weight: 500;
        }

        .price-table .driver-row td:last-child {
            color: #114B66;
        }

        .price-table .total-row td {
            padding-top: 20px;
            font-size: 18px;
            font-weight: 700;
            border-top: 2px solid #114B66;
        }

        .price-table .total-row td:last-child {
            color: #114B66;
            font-size: 28px;
            font-weight: 700;
        }

        /* Divider */
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #114B66 20%, #114B66 80%, transparent);
            margin: 25px 0 20px;
            opacity: 0.2;
        }

        /* Footer */
        .invoice-footer {
            margin-top: 30px;
        }

        .terms-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 14px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
            border: 1px solid #e9ecf0;
            margin-bottom: 25px;
            word-break: break-word;
        }

        .terms-box strong {
            color: #114B66;
        }

        .footer-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 20px;
        }

        .payment-methods {
            font-size: 13px;
        }

        .payment-methods span {
            background: #f1f5f9;
            padding: 5px 12px;
            border-radius: 20px;
            margin-right: 8px;
            font-size: 11px;
            color: #114B66;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 5px;
        }

        .payment-methods strong {
            color: #114B66;
            font-size: 14px;
        }

        .brand-signature {
            font-family: 'Times New Roman', serif;
            font-size: 24px;
            color: #114B66;
            font-weight: 600;
            font-style: italic;
            opacity: 0.8;
        }

        .print-button {
            background: #114B66;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            transition: all 0.2s;
        }

        .print-button:hover {
            background: #0d3e54;
            transform: translateY(-2px);
        }

        /* ========== RESPONSIVE MEDIA QUERIES ========== */

        /* Large Tablets (768px - 991px) */
        @media (max-width: 991px) {
            .invoice-header {
                padding: 30px 35px;
            }

            .invoice-content {
                padding: 35px;
            }

            .booking-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .company-name h1 {
                font-size: 24px;
            }

            .invoice-title h2 {
                font-size: 36px;
            }

            .price-table .total-row td:last-child {
                font-size: 24px;
            }
        }

        /* Small Tablets (576px - 767px) */
        @media (max-width: 767px) {
            body {
                padding: 10px;
            }

            .invoice-header {
                padding: 25px;
            }

            .invoice-content {
                padding: 25px;
            }

            .header-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .invoice-title {
                text-align: left;
                width: 100%;
            }

            .invoice-title h2 {
                font-size: 32px;
                margin-top: 5px;
            }

            .header-bottom {
                flex-direction: column;
                align-items: flex-start;
            }

            .status-wrapper {
                width: 100%;
                justify-content: space-between;
            }

            .date-issued {
                width: 100%;
                justify-content: space-between;
            }

            .customer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .vehicle-card {
                padding: 20px;
                gap: 20px;
            }

            .vehicle-image {
                width: 120px;
                height: 120px;
                margin: 0 auto;
            }

            .vehicle-details {
                min-width: 100%;
                text-align: center;
            }

            .vehicle-specs {
                justify-content: center;
            }

            .price-card {
                padding: 20px;
            }

            .price-table td:first-child {
                font-size: 14px;
            }

            .price-table td:last-child {
                font-size: 16px;
            }

            .price-table .total-row td:first-child {
                font-size: 16px;
            }

            .price-table .total-row td:last-child {
                font-size: 22px;
            }

            .footer-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .brand-signature {
                align-self: flex-end;
            }

            .print-button {
                width: 100%;
                justify-content: center;
            }
        }

        /* Mobile Phones (375px - 575px) */
        @media (max-width: 575px) {
            body {
                padding: 5px;
            }

            .invoice-header {
                padding: 20px;
            }

            .invoice-content {
                padding: 20px;
            }

            .logo-section {
                width: 100%;
                justify-content: center;
            }

            .company-name {
                text-align: center;
            }

            .company-name h1 {
                font-size: 22px;
            }

            .company-name .tagline {
                font-size: 10px;
            }

            .invoice-title .invoice-number {
                font-size: 12px;
                padding: 6px 15px;
            }

            .invoice-title h2 {
                font-size: 28px;
            }

            .status-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .status-label {
                font-size: 12px;
            }

            .status-badge {
                font-size: 16px;
                padding: 8px 20px;
            }

            .date-issued {
                font-size: 13px;
            }

            .customer-card {
                padding: 20px;
                margin-bottom: 25px;
            }

            .customer-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .customer-item .label {
                font-size: 10px;
            }

            .customer-item .value {
                font-size: 14px;
            }

            .section-title {
                font-size: 11px;
                margin-bottom: 15px;
            }

            .booking-grid {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 25px;
            }

            .info-card {
                padding: 15px;
            }

            .info-icon {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .info-label {
                font-size: 10px;
            }

            .info-value {
                font-size: 16px;
            }

            .info-sub {
                font-size: 11px;
            }

            .vehicle-card {
                padding: 15px;
                margin-bottom: 25px;
                flex-direction: column;
                align-items: center;
            }

            .vehicle-image {
                width: 100px;
                height: 100px;
            }

            .vehicle-name {
                font-size: 20px;
                text-align: center;
            }

            .spec-tag {
                font-size: 11px;
                padding: 4px 12px;
            }

            .vehicle-location {
                font-size: 12px;
                justify-content: center;
            }

            .price-card {
                padding: 15px;
                margin-bottom: 20px;
            }

            .price-table tr td {
                padding: 12px 0;
            }

            .price-table td:first-child {
                font-size: 13px;
            }

            .price-table td:last-child {
                font-size: 14px;
            }

            .price-table .driver-row td {
                font-size: 13px;
            }

            .price-table .total-row td {
                padding-top: 15px;
            }

            .price-table .total-row td:first-child {
                font-size: 15px;
            }

            .price-table .total-row td:last-child {
                font-size: 20px;
            }

            .divider {
                margin: 20px 0 15px;
            }

            .terms-box {
                padding: 15px;
                font-size: 11px;
                margin-bottom: 20px;
            }

            .payment-methods {
                font-size: 12px;
            }

            .payment-methods span {
                font-size: 10px;
                padding: 4px 10px;
                margin-right: 5px;
            }

            .brand-signature {
                font-size: 20px;
            }

            .print-button {
                padding: 12px 20px;
                font-size: 13px;
                margin-top: 15px;
            }
        }

        /* Small Mobile Phones (below 375px) */
        @media (max-width: 374px) {
            .invoice-header {
                padding: 15px;
            }

            .invoice-content {
                padding: 15px;
            }

            .company-name h1 {
                font-size: 18px;
            }

            .invoice-title h2 {
                font-size: 24px;
            }

            .status-badge {
                font-size: 14px;
                padding: 6px 15px;
            }

            .vehicle-name {
                font-size: 18px;
            }

            .spec-tag {
                font-size: 10px;
                padding: 3px 8px;
            }

            .price-table td:first-child {
                font-size: 12px;
            }

            .price-table td:last-child {
                font-size: 13px;
            }

            .price-table .total-row td:last-child {
                font-size: 18px;
            }

            .brand-signature {
                font-size: 18px;
            }
        }

        /* Landscape Mode */
        @media (max-height: 600px) and (orientation: landscape) {
            body {
                align-items: flex-start;
                padding: 10px;
            }

            .invoice-header {
                padding: 20px;
            }

            .header-top {
                margin-bottom: 20px;
            }

            .header-bottom {
                margin-top: 10px;
            }
        }

        /* High Resolution Screens */
        @media (min-width: 1400px) {
            .invoice-container {
                max-width: 1100px;
            }

            .invoice-header {
                padding: 45px 55px;
            }

            .invoice-content {
                padding: 55px;
            }
        }

        /* Utility classes for responsive text */
        .text-break {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .text-center-mobile {
            @media (max-width: 575px) {
                text-align: center;
            }
        }

        .d-none-mobile {
            @media (max-width: 575px) {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header with brand color and logo -->
        <div class="invoice-header">
            <div class="header-top">
                <div class="logo-section">
                    <div class="logo">
                        <img src="{{ asset('visa-booking/image/logo_tochy_travels.jpg') }}" alt="Tochy Travels Logo">
                    </div>
                    <div class="company-name">
                        <h1>TOCHY TRAVELS</h1>
                        <div class="tagline">VISA & TRAVEL SPECIALISTS</div>
                    </div>
                </div>
                <div class="invoice-title">
                    <span class="invoice-number">INVOICE #{{ $booking->booking_reference ?? 'CRB'.str_pad($booking->id,6,'0',STR_PAD_LEFT) }}</span>
                    <h2>BOOKING</h2>
                </div>
            </div>
            
            <div class="header-bottom">
                <div class="status-wrapper">
                    <span class="status-label">Status</span>
                    <span class="status-badge {{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</span>
                </div>
                <div class="date-issued">
                    <span>Issued Date:</span>
                    <strong>{{ $booking->created_at->format('d M Y') }}</strong>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="invoice-content">
            <!-- Customer Information -->
            <div class="customer-card">
                <div class="section-title">CLIENT INFORMATION</div>
                <div class="customer-grid">
                    <div class="customer-item">
                        <div class="label">Full Name</div>
                        <div class="value">{{ $booking->name }}</div>
                    </div>
                    <div class="customer-item">
                        <div class="label">Email Address</div>
                        <div class="value">{{ $booking->email }}</div>
                    </div>
                    <div class="customer-item">
                        <div class="label">Phone Number</div>
                        <div class="value">{{ $booking->phone }}</div>
                    </div>
                    <div class="customer-item">
                        <div class="label">Booking Date</div>
                        <div class="value">{{ $booking->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Booking Details Grid -->
            <div class="section-title">RENTAL DETAILS</div>
            <div class="booking-grid">
                <div class="info-card">
                    <div class="info-icon">📅</div>
                    <div class="info-label">Pickup Date</div>
                    <div class="info-value">{{ Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</div>
                    <div class="info-sub">{{ $booking->pickup_time }}</div>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">📍</div>
                    <div class="info-label">Pickup Location</div>
                    <div class="info-value">{{ Str::limit($booking->pickup_location, 20) }}</div>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">↩️</div>
                    <div class="info-label">Return Date</div>
                    <div class="info-value">{{ Carbon\Carbon::parse($booking->return_date)->format('d M Y') }}</div>
                    <div class="info-sub">{{ $days ?? \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->return_date)) + 1 }} days rental</div>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">👤</div>
                    <div class="info-label">Driver Option</div>
                    <div class="info-value">{{ $booking->with_driver ? 'With Driver' : 'Self Drive' }}</div>
                    @if($booking->with_driver)
                    <div class="info-sub">Professional driver included</div>
                    @endif
                </div>
            </div>
            
            <!-- Vehicle Details -->
            <div class="vehicle-card">
                <div class="vehicle-image">
                    @if($booking->car && $booking->car->image)
                        <img src="{{ asset('storage/'.$booking->car->image) }}" alt="{{ $booking->car->name }}">
                    @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#e2e8f0; color:#114B66; font-size:40px;">🚗</div>
                    @endif
                </div>
                <div class="vehicle-details">
                    <div class="vehicle-name">{{ $booking->car->name ?? 'Luxury Vehicle' }}</div>
                    <div class="vehicle-specs">
                        <span class="spec-tag"><i>⚙️</i> {{ $booking->car->transmission ?? 'Automatic' }}</span>
                        <span class="spec-tag"><i>⛽</i> {{ $booking->car->fuel_type ?? 'Petrol' }}</span>
                        <span class="spec-tag"><i>👥</i> {{ $booking->car->seats ?? 5 }} Seats</span>
                        <span class="spec-tag"><i>🧳</i> {{ $booking->car->luggage ?? 2 }} Bags</span>
                    </div>
                    @if($booking->car && $booking->car->location)
                    <div class="vehicle-location">
                        <span>📍</span> {{ $booking->car->location }}
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Price Breakdown -->
            <div class="price-card">
                <div class="section-title">PAYMENT SUMMARY</div>
                @php
                    $days = $days ?? \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->return_date)) + 1;
                    $carPrice = $booking->car->price_per_day ?? 0;
                    $subtotal = $carPrice * $days;
                    $driverFee = $booking->with_driver ? 10000 : 0;
                    $total = $subtotal + $driverFee;
                @endphp
                
                <table class="price-table">
                    <tr>
                        <td>Car Rental ({{ $days }} {{ Str::plural('day', $days) }} @ ₦{{ number_format($carPrice) }}/day)</td>
                        <td>₦{{ number_format($subtotal) }}</td>
                    </tr>
                    
                    @if($booking->with_driver)
                    <tr class="driver-row">
                        <td>✓ Professional Driver Service</td>
                        <td>₦{{ number_format($driverFee) }}</td>
                    </tr>
                    @endif
                    
                    <tr class="total-row">
                        <td>TOTAL AMOUNT</td>
                        <td>₦{{ number_format($total) }}</td>
                    </tr>
                </table>
                
                <div class="divider"></div>
                
                <div style="display: flex; justify-content: space-between; font-size: 13px; color: #64748b; flex-wrap: wrap; gap: 10px;">
                    <span>Amount in words: <strong>{{ number_format($total) }} Naira Only</strong></span>
                    <span>VAT: Inclusive</span>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="invoice-footer">
                <div class="terms-box">
                    <strong>TERMS & CONDITIONS:</strong> This invoice is for car rental services provided by Tochy Travels. Payment is due upon pickup. A valid driver's license and security deposit are required at the time of vehicle collection. Late returns will incur additional charges at ₦5,000 per hour. Fuel policy: Same-to-same return.
                </div>
                
                <div class="footer-row">
                    <div class="payment-methods">
                        <span>Cash</span>
                        <span>Card</span>
                        <span>Transfer</span>
                        <span>POS</span>
                        <br>
                        <strong>Booking ID:</strong> #{{ $booking->id }} | 
                        <strong>Customer ID:</strong> #CUS{{ substr($booking->phone, -4) }}
                    </div>
                    <div class="brand-signature">
                        Tochy Travels
                    </div>
                </div>
                
                <!-- Print Button -->
                <div style="text-align: center;">
                    <button class="print-button" onclick="window.print()">
                        <span>🖨️</span> Print Invoice / Save as PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>