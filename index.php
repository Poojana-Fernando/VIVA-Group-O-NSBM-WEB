<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NSBM Healthcare | Home</title>
  <link rel="stylesheet" href="styles.css" />
</head>

<body>

    <?php include 'navbar.php'; ?>


  <section class="hero">
  <div class="hero-panel">
    <p class="hero-small">Welcome to</p>
    <h1 class="hero-title">NSBM HEALTHCARE</h1>
    <p class="hero-desc">YOUR HEALTH. YOUR STUDIES. OUR PRIORITY</p>

    <div class="hero-info">
      <div class="info-row">
        <div class="info-icon">
         
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 21s7-5.2 7-11a7 7 0 0 0-14 0c0 5.8 7 11 7 11z"/>
            <circle cx="12" cy="10" r="2.2"/>
          </svg>
        </div>
        <div class="info-text">
          Homagama, Sri Lanka
          <span class="info-sub">NSBM Green University</span>
        </div>
      </div>

      <div class="info-row">
        <div class="info-icon">
        
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 3 5.2 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.6a2 2 0 0 1-.5 2.1L9.9 10.6a16 16 0 0 0 3.5 3.5l1.2-1.2a2 2 0 0 1 2.1-.5c.8.3 1.7.5 2.6.6A2 2 0 0 1 22 16.9z"/>
          </svg>
        </div>
        <div class="info-text">
          +94 11 234 5678
          <span class="info-sub">nsbmhealthcare@nsbm.lk</span>
        </div>
      </div>
    </div>
  </div>
</section>


  <div class="slider-wrap">
  <div class="slider" id="slider">
    <div class="slides" id="slides">
      <div class="slide"><img src="Assets/slide1.jpg" alt="Slide 1"></div>
      <div class="slide"><img src="Assets/slide2.jpg" alt="Slide 2"></div>
      <div class="slide"><img src="Assets/slide3.jpg" alt="Slide 3"></div>
      <div class="slide"><img src="Assets/slide4.jpg" alt="Slide 4"></div>
    </div>

    <button class="slider-btn prev" type="button" aria-label="Previous slide">&#10094;</button>
    <button class="slider-btn next" type="button" aria-label="Next slide">&#10095;</button>

    <div class="dots" id="dots"></div>
  </div>
</div>
<section class="services-wrap">
  <h2 class="services-title reveal">Our areas of expertise</h2>

  <div class="services-grid reveal">

    <a class ="service-link reveal" href="servicesPages/heart.php">
    <div class="service-tile active reveal">
      <div class="service-icon reveal">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>
        </svg>
      </div>
      <div class="service-name reveal">Heart Centre</div>
    </div>
    </a>
    
    <a class ="service-link reveal" href="servicesPages/brain.php">
    <div class="service-tile reveal">
      <div class="service-icon reveal">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <path d="M8 4a4 4 0 0 0-4 4v2a3 3 0 0 0 2 2.8V16a4 4 0 0 0 4 4"/>
          <path d="M16 4a4 4 0 0 1 4 4v2a3 3 0 0 1-2 2.8V16a4 4 0 0 1-4 4"/>
          <path d="M9 8h1M14 8h1M9 12h1M14 12h1"/>
        </svg>
      </div>
      <div class="service-name reveal">Brain &amp; Spine</div>
    </div>
    </a>

    <a class ="service-link reveal" href="servicesPages/kidney.php">
    <div class="service-tile reveal">
      <div class="service-icon reveal">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <path d="M7 3c3 0 5 3 5 7s-2 8-5 8-5-2-5-6 2-9 5-9z"/>
          <path d="M17 3c3 0 5 3 5 7s-2 8-5 8-5-2-5-6 2-9 5-9z"/>
          <path d="M12 12v9"/>
        </svg>
      </div>
      <div class="service-name reveal">Kidney Care</div>
    </div>
    </a>

    <a class ="service-link reveal" href="servicesPages/general.php">
    <div class="service-tile reveal">
      <div class="service-icon reveal">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
          <path d="M4 7h16a2 2 0 0 1 2 2v9a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V9a2 2 0 0 1 2-2z"/>
          <path d="M12 11v6M9 14h6"/>
        </svg>
      </div>
      <div class="service-name reveal">General Clinic</div>
    </div>
    </a>

  </div>
</section>
<section class="doctors-wrap" id="doctors">
  <h2 class="doctors-title reveal">Our Doctors</h2>

  <div class="doctors-grid">
    <div class="doctor-card reveal">
      <div class="doctor-photo">
        <img src="Assets/doctor1.png" alt="Dr. Radin Renula">
      </div>
      <div class="doctor-info">
        <p class="doctor-name">Dr. Radin Renula</p>
        <p class="doctor-spec">Cardiologist</p>
      </div>
    </div>

    <div class="doctor-card reveal">
      <div class="doctor-photo">
        <img src="Assets/doctor2.png" alt="Dr. Vinuka Jayavihan">
      </div>
      <div class="doctor-info">
        <p class="doctor-name">Dr. Vinuka Jayavihan</p>
        <p class="doctor-spec">Neurologist</p>
      </div>
    </div>

    <div class="doctor-card reveal">
      <div class="doctor-photo">
        <img src="Assets/doctor3.png" alt="Dr. chamidu">
      </div>
      <div class="doctor-info">
        <p class="doctor-name">Dr. Chamidu Rathnayake</p>
        <p class="doctor-spec">Nephrologist</p>
      </div>
    </div>

    <div class="doctor-card reveal">
      <div class="doctor-photo">
        <img src="Assets/doctor4.png" alt="Dr. Poojana Fernando">
      </div>
      <div class="doctor-info">
        <p class="doctor-name">Dr. Poojana Fernando</p>
        <p class="doctor-spec">General Physician</p>
      </div>
    </div>
  </div>
</section>


  <div id="about" class="section reveal">
    <h2>About Us</h2>
    <p>
      At our University Hospital, your wellbeing comes first.
       We provide safe, reliable, and student-friendly healthcare 
       from quick consultations and preventive care to specialist support, so you can stay healthy, 
       focused, and confident throughout your academic journey. Whether it’s a minor illness, a routine checkup,
        or ongoing care, we’re here with compassionate professionals, modern facilities, and fast service to help you feel
         your best because a strong future starts with good health.
    </p>
  </div>

  <div id="contact" class="section reveal">
    <h2>Contact Us</h2>
    <p>
     <strong>Contact Hospital</strong> - 011-2345678 <br>
     <strong>Email</strong> - nsbm.healthcare@nsbm.ac.lk
     <br>
     <br>
     <strong>DOCHELP - 011-2345678</strong><br>
     <strong>Emergency Help - 011-2345678</strong>
     <br>
     <br>
     <strong>Heart Specialised Center</strong> - 011-2345678 <br>
     <strong>Brain & Spine Specialist</strong> - 011-2345678 <br>
     <strong>Kidney Specialist</strong> - 011-2345678 <br>
     <strong>General Physician</strong> - 011-2345678

    </p>
  </div>


  <?php renderFooter(); ?>

    <script>
    const slider = document.getElementById("slider");
    const slidesTrack = document.getElementById("slides");
    const prevBtn = document.querySelector(".slider-btn.prev");
    const nextBtn = document.querySelector(".slider-btn.next");
    const dotsWrap = document.getElementById("dots");

    
    const originalSlides = Array.from(slidesTrack.children);
    const total = originalSlides.length;

    
    const firstClone = originalSlides[0].cloneNode(true);
    const lastClone  = originalSlides[total - 1].cloneNode(true);

    slidesTrack.appendChild(firstClone);
    slidesTrack.insertBefore(lastClone, originalSlides[0]);

    
    let index = 1; 
    let timer = null;
    let isAnimating = false;

    
    for (let i = 0; i < total; i++) {
        const dot = document.createElement("button");
        dot.type = "button";
        dot.className = "dot" + (i === 0 ? " active" : "");
        dot.addEventListener("click", () => {
        goTo(i + 1); 
        restart();
        });
        dotsWrap.appendChild(dot);
    }

    function setTransition(on) {
        slidesTrack.style.transition = on ? "transform .9s ease" : "none";
    }

    function updatePosition() {
        slidesTrack.style.transform = `translateX(-${index * 100}%)`;
    }

    function updateDots() {
        const realIndex = index - 1; // map [1..total] -> [0..total-1]
        document.querySelectorAll(".dot").forEach((d, i) => {
        d.classList.toggle("active", i === realIndex);
        });
    }

    function goTo(i) {
        if (isAnimating) return;
        isAnimating = true;

        setTransition(true);
        index = i;
        updatePosition();
        updateDots();
    }

    
    slidesTrack.addEventListener("transitionend", () => {
        isAnimating = false;

        if (index === 0) {
        
        setTransition(false);
        index = total;
        updatePosition();
        updateDots();
        }

        if (index === total + 1) {
        
        setTransition(false);
        index = 1;
        updatePosition();
        updateDots();
        }
    });

    function next() { goTo(index + 1); }
    function prev() { goTo(index - 1); }

    nextBtn.addEventListener("click", () => { next(); restart(); });
    prevBtn.addEventListener("click", () => { prev(); restart(); });

    function start() { timer = setInterval(next, 7000); } // slow
    function restart() { clearInterval(timer); start(); }

    
    slider.addEventListener("mouseenter", () => clearInterval(timer));
    slider.addEventListener("mouseleave", start);

    
    setTransition(false);
    updatePosition();
    updateDots();
    start();
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});
</script>



</body>
</html>
