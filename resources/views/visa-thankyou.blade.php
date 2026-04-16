@extends('layouts.index_layout')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<section class="thank-you-page" style="text-align:center; padding:80px 20px; background:#f7f9fb;">
    <div class="thank-container" data-aos="fade-up">
        <h1>Thank You, {{ $visaRequest->first_name }}!</h1>
        <p>Your visa assistance request for a <strong>{{ ucfirst($visaRequest->visa_type) }} Visa</strong> to <strong>{{ $visaRequest->country }}</strong> has been successfully submitted.</p>

        <!-- Progress Steps -->
        <div class="progress-steps" data-aos="fade-up" data-aos-delay="200">
            <div class="step completed">Request Submitted</div>
            <div class="step active">Consultant Review</div>
            <div class="step">Checklist & Guidance</div>
            <div class="step">Visa Application</div>
        </div>

        <!-- Personalized Checklist -->
        <div class="checklist" data-aos="fade-up" data-aos-delay="400">
            <h3>Your Personalized Checklist:</h3>
            <ul>
                @foreach($checklist as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Next Steps -->
            <div class="next-steps" data-aos="fade-up" data-aos-delay="600">
            <h3>Next Steps:</h3>
            <ol>
                <li>Our consultant will review your submission and contact you.</li>
                <li>Prepare the listed documents carefully.</li>
                <li>Optionally, download additional resources or book extra guidance.</li>
            </ol>
        </div>

        <!-- CTA / Upsells -->
        <div class="cta-buttons" data-aos="fade-up" data-aos-delay="800">
            <a href="{{ route('visa.download.pdf', $visaRequest->id) }}" class="hero-btn">
    Download Full Checklist PDF
</a>
 <a href="{{ url('/extra-guidance') }}" class="hero-btn" style="margin-left:15px;">Book Extra Guidance Session</a>
        </div>
    </div>
</section>

<style>
.thank-container { max-width:900px; margin:0 auto; background:#fff; padding:40px; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.1); }

.thank-container h1 { color:#116682; font-size:2.5rem; margin-bottom:10px; }
.thank-container p { font-size:1.1rem; color:#555; margin-bottom:25px; }

.progress-steps { display:flex; justify-content:space-between; margin:30px 0; position:relative; }
.progress-steps::before { content:""; position:absolute; top:50%; left:0; right:0; height:4px; background:#e0e0e0; transform:translateY(-50%); z-index:0; }
.progress-steps .step { background:#e0e0e0; padding:10px 20px; border-radius:50px; position:relative; z-index:1; font-weight:600; color:#666; transition:0.3s; }
.progress-steps .step.active { background:#116682; color:#fff; }
.progress-steps .step.completed { background:#28a745; color:#fff; }

.checklist ul { list-style-type:disc; margin-left:20px; margin-top:15px; text-align:left; }
.next-steps ol { text-align:left; max-width:600px; margin:20px auto; }
.hero-btn { padding:12px 28px; background:#116682; color:#fff; border-radius:8px; font-weight:600; text-decoration:none; transition:0.3s; display:inline-block; margin-top:10px; }
.hero-btn:hover { background:#114f66; }
</style>

<script>
AOS.init({ duration:800, once:true });
</script>
@endsection
