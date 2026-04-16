// ===== NAVBAR SCROLL EFFECT =====
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.my-navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});


// ===== PACKAGE FILTER BUTTONS =====
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".filter-buttons a");
    const container = document.getElementById("packagesContainer");

    buttons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            buttons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            const country = this.getAttribute("data-country");

            container.innerHTML = "<p style='text-align:center;'>Loading...</p>";

            fetch(`/filter-packages?country=${country}`)
                .then(res => res.text())
                .then(data => {
                    container.innerHTML = data;
                });
        });
    });
});


// ===== CAROUSEL (DESTINATIONS) =====
const track = document.querySelector('.carousel-track');
const slides = document.querySelectorAll('.slide');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');

let index = 0;

function updateCarousel() {
    track.style.transform = `translateX(-${index * 100}%)`;
}

prevBtn.addEventListener("click", () => {
    index = (index === 0) ? slides.length - 1 : index - 1;
    updateCarousel();
});

nextBtn.addEventListener("click", () => {
    index = (index === slides.length - 1) ? 0 : index + 1;
    updateCarousel();
});


// ===== TESTIMONIAL CAROUSEL (TABLET) =====
document.addEventListener("DOMContentLoaded", function () {
    if (window.innerWidth >= 768 && window.innerWidth <= 1024) {
        const carousel = document.getElementById("testimonial-carousel");
        const slides = carousel.querySelectorAll(".box-client");
        const totalSlides = slides.length;
        let index = 0;

        carousel.innerHTML += carousel.innerHTML;

        const dotsContainer = document.createElement("div");
        dotsContainer.className = "testimonial-dots";
        carousel.parentNode.insertBefore(dotsContainer, carousel.nextSibling);

        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement("span");
            if (i === 0) dot.classList.add("active");
            dotsContainer.appendChild(dot);

            dot.addEventListener("click", () => {
                index = i;
                updateCarousel();
            });
        }

        const dots = dotsContainer.querySelectorAll("span");

        function updateCarousel() {
            const slideWidth = slides[0].offsetWidth + 24;
            carousel.style.transform = `translateX(-${index * slideWidth}px)`;

            dots.forEach(dot => dot.classList.remove("active"));
            dots[index % totalSlides].classList.add("active");
        }

        setInterval(() => {
            index++;
            if (index >= totalSlides) index = 0;
            updateCarousel();
        }, 4000);
    }
});


// ===== TESTIMONIAL CAROUSEL (MOBILE) =====
document.addEventListener("DOMContentLoaded", function () {
    if (window.innerWidth > 767) return;

    const container = document.getElementById("testimonial-carousel");
    const slides = container.querySelectorAll(".box-client");
    const total = slides.length;

    let index = 0;

    const dotsContainer = document.createElement("div");
    dotsContainer.className = "testimonial-dots";

    slides.forEach((_, i) => {
        const dot = document.createElement("span");
        if (i === 0) dot.classList.add("active");

        dot.addEventListener("click", () => {
            index = i;
            updateCarousel();
        });

        dotsContainer.appendChild(dot);
    });

    container.after(dotsContainer);

    const dots = dotsContainer.querySelectorAll("span");

    function updateCarousel() {
        const width = container.clientWidth;
        container.scrollTo({
            left: width * index,
            behavior: "smooth"
        });

        dots.forEach(d => d.classList.remove("active"));
        dots[index].classList.add("active");
    }

    function autoSlide() {
        index++;
        if (index >= total) index = 0;
        updateCarousel();
    }

    setInterval(autoSlide, 3000);
});


// ===== ACTIVE NAV LINK + SHIMMER ON SCROLL =====
const navLinks = document.querySelectorAll('.nav-link');
const navItems = document.querySelectorAll('.nav-item');

const sections = Array.from(navLinks)
    .map(link => document.querySelector(link.getAttribute('href')))
    .filter(Boolean);

if (sections.length === 0) {
    console.warn('No sections found for nav links — check your href / id values.');
} else {
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -20% 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.target || !entry.target.id) return;

            if (entry.isIntersecting) {
                const id = entry.target.id;

                navItems.forEach(item => {
                    const link = item.querySelector('a');
                    if (!link) return;

                    if (link.getAttribute('href') === `#${id}`) {
                        item.classList.add('active');
                        item.classList.add('shimmer');
                        setTimeout(() => item.classList.remove('shimmer'), 1000);
                    } else {
                        item.classList.remove('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(s => observer.observe(s));
}


// ===== CHAT LAUNCHER =====
const launcher = document.getElementById('visa-chat-launcher');
const panel = document.getElementById('visa-chat-panel');
const closeBtn = document.getElementById('visa-chat-close');
const body = document.getElementById('visaChatBody');
const input = document.getElementById('visaChatInput');
const send = document.getElementById('visaChatSend');

launcher.onclick = () => panel.style.display = 'flex';
closeBtn.onclick = () => panel.style.display = 'none';

send.onclick = sendMessage;

input.addEventListener('keypress', e => {
    if (e.key === 'Enter') sendMessage();
});

document.querySelectorAll('.quick-options button').forEach(btn => {
    btn.onclick = () => handleUser(btn.dataset.msg);
});

function sendMessage() {
    const msg = input.value.trim();
    if (!msg) return;
    handleUser(msg);
    input.value = '';
}

function handleUser(msg) {
    appendMsg(msg, 'user');

    const typingEl = appendMsg("Typing...", 'system');

    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: msg })
    })
    .then(res => res.json())
    .then(data => {
        typingEl.remove();

        if (data.reply) {
            setTimeout(() => {
                appendMsg(data.reply, 'system');
            }, 700 + Math.random() * 800);
        } else {
            appendMsg("Sorry, I didn't understand that. Please try again.", 'system');
        }
    })
    .catch(error => {
        typingEl.remove();
        appendMsg("Server error. Please try again.", 'system');
        console.error(error);
    });
}

function appendMsg(text, type) {
    const div = document.createElement('div');
    div.className = `visa-msg ${type}`;
    div.innerText = text;
    body.appendChild(div);
    body.scrollTop = body.scrollHeight;
    return div;
}


// ===== HERO SECTION ANIMATION OBSERVER =====
const heroObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            } else {
                entry.target.classList.remove('animate');
            }
        });
    },
    { threshold: 0.35 }
);

document.querySelectorAll('.background').forEach(section => {
    heroObserver.observe(section);
});


// ===== ABOUT US REVEAL =====
document.addEventListener("DOMContentLoaded", () => {
    const revealElements = document.querySelectorAll(".about-us");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("reveal");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.25 }
    );

    revealElements.forEach(el => observer.observe(el));
});


// ===== SERVICES CARDS REVEAL =====
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".real-info");

    const observer = new IntersectionObserver(
        entries => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add("reveal");
                    }, index * 120);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.25 }
    );

    cards.forEach(card => observer.observe(card));
});


// ===== FOOTER REVEAL =====
const footer = document.querySelector('.footer');

const footerObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            footer.classList.add('show');
        }
    });
});

footerObserver.observe(footer);


// ===== PRELOADER =====
window.addEventListener("load", function () {
    const loader = document.getElementById("preloader");

    setTimeout(() => {
        loader.classList.add("hide");
    }, 2600);
});


// ===== SCROLL TO TOP BUTTON =====
const topBtn = document.getElementById("scrollTopBtn");

window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
        topBtn.classList.add("show");
    } else {
        topBtn.classList.remove("show");
    }
});

topBtn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});