@extends('layouts.index_layout')

@section('content')

<section class="extra-guidance-hero">
    <div class="container">
        <h1>
            One-on-One <span>Visa Guidance</span><br>
            With Certified Experts
        </h1>

        <p class="hero-text">
            Get personalized, professional support for your visa application.
            We review your documents, identify red flags, and guide you step-by-step
            to improve your approval chances.
        </p>

        <a href="{{ route('visa.form') }}" class="hero-btn large">
            Book Your Guidance Session
        </a>
    </div>
</section>

<section class="extra-guidance-content">
    <div class="container">

        <div class="section-header">
            <h2>What This Session Includes</h2>
            <p>
                Designed for applicants who want clarity, confidence,
                and expert review before submitting to an embassy.
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <h3>Document Review</h3>
                <p>
                    We carefully review your documents to ensure accuracy,
                    completeness, and embassy compliance.
                </p>
            </div>

            <div class="feature-card">
                <h3>Embassy-Specific Advice</h3>
                <p>
                    Get guidance tailored to your destination country and visa type,
                    not generic information.
                </p>
            </div>

            <div class="feature-card">
                <h3>Red-Flag Detection</h3>
                <p>
                    We identify weak points in your application that could lead to
                    delays or rejection — before submission.
                </p>
            </div>

            <div class="feature-card">
                <h3>Interview Preparation</h3>
                <p>
                    Receive practical interview tips, common questions,
                    and confidence-boosting strategies.
                </p>
            </div>
        </div>

    </div>
</section>

<section class="extra-guidance-cta">
    <div class="container">
        <h2>
            Serious About Your Visa?<br>
            Let’s Do It Right.
        </h2>

        <p>
            Embassies don’t give second chances easily.
            A professional review can make the difference between approval and refusal.
        </p>

        <a href="{{ route('visa.form') }}" class="hero-btn large dark">
            Secure Your Session Now
        </a>
    </div>
</section>
<style>
    /* =========================
   GLOBAL BUTTON STYLE
========================= */
.hero-btn {
    display: inline-block;
    text-decoration: none;
    background: linear-gradient(135deg, #1aa3c8, #34c6e3);
    color: #ffffff;
    font-weight: 600;
    font-size: 1.05rem;
    padding: 14px 36px;
    border-radius: 50px;
    letter-spacing: 0.3px;
    box-shadow: 0 12px 30px rgba(26,163,200,0.35);
    transition: all 0.35s ease;
    position: relative;
    overflow: hidden;
}

.hero-btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 140%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255,255,255,0.45),
        transparent
    );
    transition: 0.6s ease;
}

.hero-btn:hover::before {
    left: 100%;
}

.hero-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 45px rgba(26,163,200,0.45);
}

/* Dark button */
.hero-btn.dark {
    background: #ffffff;
    color: #0f3c4c;
    box-shadow: 0 12px 35px rgba(0,0,0,0.18);
}

.hero-btn.dark:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 50px rgba(0,0,0,0.28);
}

/* =========================
   HERO SECTION
========================= */
.extra-guidance-hero {
    padding: 110px 0;
    background: linear-gradient(135deg, #0f3c4c, #116682);
    color: #ffffff;
    margin-top: 0 !important;
}
.extra-guidance-hero h1 {
    font-size: 3.2rem;
    font-weight: 700;
    line-height: 1.2;
    padding-top: 3rem;
}

.extra-guidance-hero h1 span {
    color: #9fe0f0;
}

.extra-guidance-hero .hero-text {
    font-size: 1.15rem;
    max-width: 650px;
    margin: 25px 0 40px;
    color: #e3f6fb;
}

/* =========================
   CONTENT SECTION
========================= */
.extra-guidance-content {
    padding: 95px 0;
    background: #f9fcfd;
}

.section-header h2 {
    font-size: 2.4rem;
    margin-bottom: 14px;
    color: #0f3c4c;
}

.section-header p {
    font-size: 1.05rem;
    max-width: 600px;
    color: #555;
}

/* =========================
   FEATURE CARDS
========================= */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 55px;
}

.feature-card {
    background: linear-gradient(180deg, #ffffff, #f8fdff);
    padding: 36px;
    border-radius: 22px;
    border: 1px solid rgba(17,102,130,0.08);
    box-shadow: 0 18px 45px rgba(0,0,0,0.06);
    transition: all 0.4s ease;
    position: relative;
}

.feature-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, #1aa3c8, #34c6e3);
    border-radius: 22px 22px 0 0;
    opacity: 0;
    transition: 0.35s ease;
}

.feature-card:hover::before {
    opacity: 1;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 70px rgba(0,0,0,0.1);
}

.feature-card h3 {
    font-size: 1.35rem;
    margin-bottom: 12px;
    color: #0f3c4c;
}

.feature-card p {
    font-size: 1rem;
    line-height: 1.7;
    color: #555;
}

/* =========================
   CTA SECTION
========================= */
.extra-guidance-cta {
    padding: 95px 0;
    background: #0f3c4c;
    color: #ffffff;
    text-align: center;
}

.extra-guidance-cta h2 {
    font-size: 2.5rem;
    margin-bottom: 18px;
}

.extra-guidance-cta p {
    font-size: 1.1rem;
    max-width: 650px;
    margin: 0 auto 38px;
    color: #d7f0f6;
}

/* =========================
   SMOOTH PAGE ANIMATION
========================= */
.extra-guidance-hero,
.section-header,
.feature-card,
.extra-guidance-cta {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeUp 0.9s ease forwards;
}

.section-header { animation-delay: 0.2s; }
.feature-card:nth-child(1) { animation-delay: 0.35s; }
.feature-card:nth-child(2) { animation-delay: 0.5s; }
.feature-card:nth-child(3) { animation-delay: 0.65s; }
.feature-card:nth-child(4) { animation-delay: 0.8s; }
.extra-guidance-cta { animation-delay: 0.95s; }

@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
@endsection
