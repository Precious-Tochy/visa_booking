@extends('layouts.index_layout')
@section('content')

<!-- HERO SECTION -->
<div class="background1">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Professional Visa Assistance & Application Support</h1>
        <p>Guidance, documentation checklists, and personalized consultation for all visa types.</p>
        <a href="#visa-form" class="hero-btn">Get Started</a>
    </div>
    <i class="ri-arrow-down-line scroll-arrow"></i>
</div>

<!-- PAGE TITLE -->
<section class="page-title">
    <h2>Visa Assistance</h2>
    <h1>Start Your Visa Application</h1>
</section>

<div class="contact-container">

    <!-- CONTACT INFO -->
    <div class="contact-info" data-aos="fade-right">
        <h4>Need Visa Guidance?</h4>
        <p><i class="ri-phone-fill"></i> (+234) 905 353 1176</p>
        <p><i class="ri-map-pin-fill"></i> Plot 140 Unity Estate 3-3 Onitsha, Anambra.</p>
        <iframe src="https://www.google.com/maps?q=Plot+140+Unity+Estate+3-3+Onitsha,+Anambra&output=embed" 
            width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <!-- FORM & HOW IT WORKS -->
    <div class="contact-form-container" data-aos="fade-left">

        <!-- TRUST BADGES -->
        <div class="trust-badges" style="display:flex;gap:15px;margin-bottom:20px;">
            <div class="badge"><i class="ri-shield-check-line"></i> Secure & Confidential</div>
            <div class="badge"><i class="ri-time-line"></i> Fast Response</div>
            <div class="badge"><i class="ri-chat-3-line"></i> Personalized Support</div>
        </div>

        <!-- HOW IT WORKS -->
        <div class="how-it-works">
            <h3>How Visa Assistance Works</h3>
            <div class="steps-container">
                <div class="step" data-aos="fade-up">
                    <i class="ri-file-list-2-line"></i>
                    <strong>Submit Your Request:</strong> Fill the form with visa type, destination, and personal info.
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="100">
                    <i class="ri-user-check-line"></i>
                    <strong>Profile Review:</strong> Our consultant evaluates your eligibility and documents.
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="200">
                    <i class="ri-checkbox-circle-line"></i>
                    <strong>Document Checklist:</strong> Receive a dynamic checklist with instructions for your visa type.
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="300">
                    <i class="ri-clipboard-line"></i>
                    <strong>Application Support:</strong> Guidance on form filling, submission, and embassy procedures.
                </div>
                <div class="step" data-aos="fade-up" data-aos-delay="400">
                    <i class="ri-chat-3-line"></i>
                    <strong>Follow-Up & Updates:</strong> Keep updated on your application status and next steps.
                </div>
            </div>
            <p class="disclaimer">
                *We provide visa assistance and documentation guidance only. Visa approvals are made solely by the embassy or consulate.
            </p>
        </div>

        <!-- DOCUMENT CHECKLIST -->
        <div id="dynamic-checklist" style="margin-bottom:20px;"></div>

        <!-- VISA ASSISTANCE FORM -->
        <form id="visa-form" class="contact-form" method="POST" action="{{ route('visa.assist') }}">
            @csrf

            <!-- Visa Type & Country -->
            <div class="row">
                <div class="form-group">
                    <h4>Visa Type</h4>
                    <select name="visa_type" id="visa_type" required>
                        <option value="">-- Select Visa Type --</option>
                        <option value="tourist">Tourist Visa</option>
                        <option value="study">Study Visa</option>
                        <option value="work">Work Visa</option>
                        <option value="business">Business Visa</option>
                        <option value="transit">Transit Visa</option>
                    </select>
                </div>
                <div class="form-group">
                    <h4>Destination Country</h4>
                    <select name="country" id="country" required>
                        <option value="">-- Select Country --</option>
                        <option value="USA">United States</option>
                        <option value="UK">United Kingdom</option>
                        <option value="Canada">Canada</option>
                        <option value="Schengen">Schengen Countries</option>
                        <option value="UAE">UAE</option>
                    </select>
                </div>
            </div>

            <!-- Applicant Info -->
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
                    <h4>Occupation (Optional)</h4>
                    <input type="text" name="occupation">
                </div>
                <div class="form-group">
                    <h4>Previous Travel History</h4>
                    <select name="travel_history">
                        <option value="">-- Select --</option>
                        <option value="none">No Previous Travel</option>
                        <option value="africa">Africa Only</option>
                        <option value="international">International Travel</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <h4>Preferred Consultation</h4>
                    <select name="consultation">
                        <option value="whatsapp">WhatsApp</option>
                        <option value="phone">Phone Call</option>
                        <option value="office">Office Visit</option>
                    </select>
                </div>
            </div>

            <h4>Additional Notes</h4>
            <textarea name="notes" placeholder="Tell us about your travel purpose or concerns"></textarea>

            <button type="submit">Request Visa Assistance</button>
        </form>

    </div>
</div>

<!-- Scripts -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
AOS.init({ duration: 800, once: true });

const checklistData = {
    tourist: ["Passport", "Photos", "Bank Statement", "Travel Itinerary", "Hotel Reservation", "Flight Reservation"],
    study: ["Passport", "Admission Letter", "Academic Certificates", "Bank Statement", "Language Proof (IELTS/TOEFL)"],
    work: ["Passport", "Offer Letter", "CV", "Professional Certificates", "Police Clearance"],
    business: ["Passport", "Invitation Letter", "Company Documents", "Bank Statement", "Business Profile"],
    transit: ["Passport", "Confirmed Flight", "Visa for Final Destination if needed"]
};

const visaType = document.getElementById('visa_type');
const checklistDiv = document.getElementById('dynamic-checklist');

visaType.addEventListener('change', function() {
    checklistDiv.innerHTML = '';
    const selected = this.value;
    if(checklistData[selected]){
        let html = '<h4>Visa Document Checklist:</h4><ul>';
        checklistData[selected].forEach(doc => {
            html += `<li>${doc}</li>`;
        });
        html += '</ul>';
        checklistDiv.innerHTML = html;
    }
});

// AJAX form submission
// AJAX form submission
document.getElementById('visa-form').addEventListener('submit', function(e){
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success'){
            Swal.fire({
                title: '🎉 Request Submitted Successfully!',
                html: `
                    <p>Dear <strong>${data.visa.first_name}</strong>, your visa assistance request has been received.</p>
                    <p>Check your email (<strong>${data.visa.email}</strong>) for confirmation and next steps.</p>
                    <p>You can also access your personalized document checklist and guidance on the next page.</p>
                `,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Go to Next Steps',
                cancelButtonText: 'Stay on This Page',
                customClass: {
                    popup: 'swal2-popup-custom',
                    title: 'swal2-title-custom',
                    htmlContainer: 'swal2-html-custom',
                    confirmButton: 'swal2-confirm-custom',
                    cancelButton: 'swal2-cancel-custom'
                },
                buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = `/visa-assistance/thank-you/${data.visa.id}`;
                }
            });

            form.reset();
            checklistDiv.innerHTML = '';
        } else {
            Swal.fire({
                icon:'error',
                title:'Submission Failed',
                text:data.message || 'Please check your inputs and try again.',
                confirmButtonColor:'#116682'
            });
        }
    })
    .catch(err => Swal.fire({
        icon:'error',
        title:'Error',
        text:'Something went wrong. Please try again later.',
        confirmButtonColor:'#116682'
    }));
});

</script>

<style>
    /* SweetAlert2 Custom Styles */
.swal2-popup-custom {
    border-radius: 12px;
    padding: 2rem 2.5rem;
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    color: #243F36;
    box-shadow: 0 12px 28px rgba(0,0,0,0.25);
}

.swal2-title-custom {
    font-size: 1.8rem !important;
    color: #116682 !important;
    font-weight: 700 !important;
}

.swal2-html-custom p {
    margin: 10px 0;
    line-height: 1.5;
}

.swal2-confirm-custom, .swal2-cancel-custom {
    padding: 10px 25px;
    font-size: 15px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}

.swal2-confirm-custom {
    background-color: #116682;
    color: #fff;
    border: none;
}

.swal2-confirm-custom:hover {
    background-color: #114f66;
}

.swal2-cancel-custom {
    background-color: #e6f0f0;
    color: #116682;
    border: none;
}

.swal2-cancel-custom:hover {
    background-color: #d0e1e3;
}

/* HERO SECTION */
.background1 { position: relative; height: 100vh; background-image: url('{{ asset('visa-booking/image/Quer descobrir como comprar passagens aéreas….jpeg') }}'); background-size: cover; background-position: center; }
.hero-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); }
.hero-content { position: absolute; top: 40%; left:50%; transform: translateX(-50%); text-align: center; color:#fff; max-width:700px; }
.hero-content h1 { font-size: 3rem; margin-bottom: 0.5rem; }
.hero-content p { font-size: 1.2rem; margin-bottom: 1.5rem; }
.hero-btn { padding: 12px 28px; background:#116682; color:#fff;border-radius: 8px; font-weight:600; text-decoration:none; transition:0.3s; }
.hero-btn:hover { background:#114f66; }
.scroll-arrow { font-size:4.5rem; color:#fff; animation: bounceDown 0.9s infinite; position:absolute; bottom:5%; left:47%; transform:translateX(-50%); }
@keyframes bounceDown {0%,100%{transform:translateY(0);}50%{transform:translateY(12px);}}

/* PAGE TITLE */
.page-title { text-align:center; margin:2rem 0; }
.page-title h2 { color:#116682; font-weight:600; }
.page-title h1 { font-size:2.5rem; margin-top:0.5rem; }

/* CONTACT CONTAINER */
.contact-container { display:flex; gap:30px; flex-wrap:wrap; justify-content:center; padding:20px; margin: 2rem; }
.contact-info { flex:1; min-width:300px; background:#f2f2f2; padding:20px; border-radius:10px; }
.contact-info h4 { font-size:1.5rem; margin-bottom:15px; }
.contact-info i { margin-right:8px; color:#116682; }
.contact-form-container { flex:2; min-width:320px; background:#f2f2f2; padding:25px; border-radius:10px; }

/* TRUST BADGES */
.trust-badges { margin-bottom:20px; }
.trust-badges .badge { display:flex; align-items:center; gap:8px; background:#e6f0f0; padding:8px 12px; border-radius:6px; font-size:14px; }

/* HOW IT WORKS */
.how-it-works h3 { color:#116682; margin-bottom:15px; font-weight:700; }
.steps-container { display:flex; flex-direction:column; gap:15px; }
.step { display:flex; align-items:flex-start; gap:10px; background:#fff; padding:12px 15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
.step i { font-size:28px; flex-shrink:0; }

/* FORM STYLING */
.contact-form { margin-top:20px; }
.contact-form .row { display:flex; gap:15px; margin-bottom:15px; flex-wrap:wrap; }
.contact-form input, .contact-form select, .contact-form textarea { width:100%; padding:12px; border:1px solid #ccc; border-radius:6px; font-size:14px; }
.contact-form textarea { height:100px; }
.contact-form h4 { margin-bottom:5px; font-size:16px; }
.contact-form button { padding:12px 28px; background:#116682; color:#fff; font-size:18px; font-weight:600; border:none; border-radius:8px; cursor:pointer; transition:0.3s; }
.contact-form button:hover { background:#114f66; }


/* DISCLAIMER */
.disclaimer { font-size:12px; font-style:italic; color:#555; margin-top:10px; }

/* RESPONSIVE */
@media(max-width:900px){ .contact-container { flex-direction:column; } }
body{
    overflow-x: hidden;
}
</style>

@endsection
