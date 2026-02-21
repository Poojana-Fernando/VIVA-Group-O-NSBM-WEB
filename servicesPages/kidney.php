<?php session_start(); $basePath = '../'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kidney Care | NSBM Healthcare</title>
  <link rel="stylesheet" href="../styles.css" />

  <style>
    /* ===== Banner ===== */
    .top-banner{
      width: 100%;
      height: 400px;
      overflow: hidden;
      background: #e6ebe5;
    }
    .top-banner img{
      width: 100%;
      height: 100%;
      object-fit: cover;
      display:block;
    }

    /* ===== Content ===== */
    .page{
      width: 100%;
      margin: -30px 0 0;
      padding: 0 0 10px;
    }

    .service-box{
      background:#40be42;
      border: 1px solid var(--border);
      border-radius: 0;
      box-shadow: 0 18px 45px rgba(15,23,42,.12);
      padding: 32px 40px;
      width: 100%;
    }

    .service-box h1{
      margin: 0 0 10px;
      font-size: 42px;
      letter-spacing: -0.02em;
      color: #ffffff;
    }

    .service-box p{
      margin: 0 0 14px;
      line-height: 1.7;
      font-size: 16px;
      color: #ffffff;
    }

    .service-box ul{
      margin: 0;
      padding-left: 20px;
      line-height: 1.7;
      color: #ffffff;
    }

    @media (max-width: 700px){
      .top-banner{ height: 220px; }
      .service-box h1{ font-size: 32px; }
    }
  </style>
</head>

<body>

  <?php include '../navbar.php'; ?>

  <header class="top-banner">
    <img src="../Assets/services/slide3.jpg" alt="Kidney Centre Banner">
  </header>

  <main class="page">
    <section class="service-box">
      <h1>Kidney Care</h1>
      <p>
        Our Kidney Care department supports students and staff with renal consultations,
        basic screening, and guidance for a healthier lifestyle.
      </p>

      <ul>
        <li>Blood pressure and pulse checks</li>
        <li>Chest pain / palpitations initial assessment</li>
        <li>Health advice: diet, exercise, stress management</li>
        <li>Referrals to specialist care when needed</li>
      </ul>
    </section>
  </main>

<?php renderFooter(); ?>
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
