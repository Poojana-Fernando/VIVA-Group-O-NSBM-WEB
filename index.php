<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-Channeling | Home</title>

  <style>
    :root{
      --green:#22c55e;
      --green-dark:#16a34a;
      --blue:#2563eb;
      --blue-dark:#1d4ed8;
      --text:#0f172a;
      --muted:#64748b;
      --bg:#f6f8fb;
      --card:#ffffff;
      --border:rgba(15,23,42,.10);
      --shadow: 0 12px 30px rgba(15,23,42,.10);
      --shadow-soft: 0 8px 18px rgba(15,23,42,.08);
      --radius:16px;
    }

    *{ box-sizing:border-box; }

    body{
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      margin:0;
      color:var(--text);
      line-height:1.6;
      background:var(--bg);
    }

    
    .navbar{
      position: sticky;
      top: 0;
      z-index: 1000;

      background: rgba(255,255,255,.75);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);

      border-bottom: 1px solid var(--border);
      padding: 14px 28px;

      display:flex;
      align-items:center;
      gap:16px;
    }

    
    .nsbm-logo{
      display:flex;
      align-items:center;
    }
    .nsbm-logo img{
      height: 60px;     
      width: auto;
      display:block;
      object-fit: contain;
    }

    
    .nav-actions{
      display:flex;
      gap:12px;
    }

    
    .nav-links{
      margin-left:auto;
      display:flex;
      gap:18px;
    }
    .nav-links a{
      text-decoration:none;
      color: var(--muted);
      font-weight:600;
      padding: 8px 10px;
      border-radius: 10px;
      transition: .2s;
    }
    .nav-links a:hover{
      color: var(--text);
      background: rgba(37,99,235,.08);
    }

    
    .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;

      padding: 10px 16px;
      border-radius: 999px;
      text-decoration:none;
      font-weight:700;
      border: 1px solid transparent;
      transition: .2s ease;
      cursor:pointer;
      box-shadow: 0 6px 14px rgba(15,23,42,.08);
    }

    .btn-book{
      background: var(--blue);
      color: #fff;
    }
    .btn-book:hover{
      background: var(--blue-dark);
      transform: translateY(-1px);
    }

    .btn-doc{
      background: var(--green);
      color:#fff;
    }
    .btn-doc:hover{
      background: var(--green-dark);
      transform: translateY(-1px);
    }

    
    .nav-btn{ padding: 9px 14px; font-size: 14px; }

    
    .hero{
      padding: 92px 20px 110px;
      text-align:center;
      color:white;
      background:
        radial-gradient(900px 380px at 50% 30%, rgba(255,255,255,.18), transparent 60%),
        linear-gradient(135deg, #47ce3a 0%, #47ce3a 45%, #47ce3a 100%);
    }
    .hero h1{
      font-size: clamp(34px, 4vw, 54px);
      margin:0 0 10px;
      letter-spacing: -0.02em;
    }
    .hero p{
      margin:0;
      color: rgba(255,255,255,.9);
      font-size: 16px;
    }

    
    .cta-section{
      display:flex;
      justify-content:center;
      gap:22px;
      margin-top: -55px;
      padding: 0 20px;
      flex-wrap: wrap;
    }

    .card{
      background: rgba(255,255,255,.90);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);

      border: 1px solid var(--border);
      padding: 28px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      width: min(360px, 92vw);
      text-align:center;
      transition: .2s ease;
    }
    .card:hover{
      transform: translateY(-4px);
      box-shadow: 0 18px 40px rgba(15,23,42,.14);
    }
    .card h3{
      margin: 4px 0 8px;
      font-size: 20px;
    }
    .card p{
      margin: 0 0 18px;
      color: var(--muted);
    }

    
    .section{
      padding: 70px 20px;
      max-width: 1000px;
      margin: auto;
    }
    .section h2{
      margin:0 0 10px;
      font-size: 28px;
      letter-spacing: -0.01em;
    }
    .section p{ color: var(--muted); }

    #contact.section{
      background: #fff;
      border-radius: 22px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-soft);
      padding: 50px 20px;
    }

    
    footer{
      background: #0b1220;
      color: rgba(255,255,255,.85);
      text-align:center;
      padding: 28px 16px;
      margin-top: 50px;
      border-top: 1px solid rgba(255,255,255,.08);
    }

    
    @media (max-width: 720px){
      .navbar{ padding: 12px 14px; gap: 10px; flex-wrap: wrap; }
      .nav-actions{ width: 100%; }
      .nav-links{ margin-left: 0; width: 100%; justify-content: flex-start; }
    }
    
    .slider-wrap{
    max-width: 1500px;
    margin: -60px auto 0;
    padding: 0 20px;
    }

    .slider{
    position: relative;
    overflow: hidden;
    border-radius: 22px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    background: #fff;
    }

    .slides{
    display: flex;
    transition: transform .9s ease;
    will-change: transform;
    }

    .slide{
    flex: 0 0 100%;
    width: 100%;
    height: 600px;
    background: #e5e7eb;
    }

    .slide img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    }

    
    .slider-btn{
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    border: 0;
    width: 44px;
    height: 44px;
    border-radius: 999px;
    background: rgba(255,255,255,.8);
    box-shadow: 0 10px 20px rgba(15,23,42,.15);
    cursor: pointer;
    font-size: 18px;
    display: grid;
    place-items: center;
    transition: .2s;
    }
    .slider-btn:hover{ background: rgba(255,255,255,.95); }
    .slider-btn.prev{ left: 12px; }
    .slider-btn.next{ right: 12px; }


    .dots{
    position: absolute;
    left: 0;
    right: 0;
    bottom: 12px;
    display: flex;
    justify-content: center;
    gap: 8px;
    }
    .dot{
    width: 10px;
    height: 10px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,.8);
    background: rgba(255,255,255,.45);
    cursor: pointer;
    transition: .2s;
    }
    .dot.active{
    background: rgba(255,255,255,.95);
    transform: scale(1.15);
    }

    
    @media (max-width: 720px){
    .slide{ height: 240px; }
    .slider-wrap{ margin-top: -40px; }
    }

  </style>
</head>

<body>

    <div class="navbar">
    <a href="index.php" class="nsbm-logo">
        <img src="Assets/logo.png" alt="nsbm-logo">
    </a>

    <div class="nav-links">
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </div>

    <div class="nav-actions">
        <a href="book_now.php" class="btn btn-book nav-btn">Book Now</a>

        <?php if(isset($_SESSION['doctor_id'])): ?>
        <a href="doctor_dashboard.php" class="btn btn-doc nav-btn">Dashboard</a>
        <?php else: ?>
        <a href="doctor_login.html" class="btn btn-doc nav-btn">Doctor Login</a>
        <?php endif; ?>
    </div>
    </div>


  <div class="hero">
    <h1>BETTER CARE. BETTER LIFE</h1>
    <p>Stay healthy, focused, and confident throughout your university life.</p>
  </div>

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


  <div id="about" class="section">
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

  <div id="contact" class="section">
    <h2>Contact Us</h2>
    <p><strong>Email:</strong> nsbmhealthcare@nsbm.lk</p>
    <p><strong>Phone:</strong> +94 11 234 5678</p>
    <p><strong>Location:</strong> Homagama, Sri Lanka</p>
  </div>

  <footer>
    <p>&copy; 2026 E-Channeling System. All Rights Reserved.</p>
  </footer>

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

    function start() { timer = setInterval(next, 7000); }
    function restart() { clearInterval(timer); start(); }

    
    slider.addEventListener("mouseenter", () => clearInterval(timer));
    slider.addEventListener("mouseleave", start);

    
    setTransition(false);
    updatePosition();
    updateDots();
    start();
</script>



</body>
</html>
