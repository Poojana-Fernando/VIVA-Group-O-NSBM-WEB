<?php
session_start();
$basePath = '../';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kidney Care | NSBM Healthcare</title>
  <link rel="stylesheet" href="../servicestyle.css" />

</head>

<body>

  <?php include '../navbar.php'; ?>

  <header class="top-banner">
    <img src="../Assets/services/slide3.jpg" alt="Kidney Centre Banner">
  </header>

  <main class="page reveal">
    <section class="service-box reveal">
      <h1>Kidney Care</h1>
      <p>
  Our Kidney Care Clinic supports students and staff with kidney-related consultations,
  screening, and guidance to protect long-term kidney health.
</p>

<ul>
  <li>Blood pressure and blood sugar checks (kidney risk screening)</li>
  <li>Urine tests for protein / infection (basic screening)</li>
  <li>Advice on hydration, salt intake, and kidney-friendly diet</li>
  <li>Referral for lab tests and specialist care when needed</li>
</ul>
    </section>
  <section class="image-gallery reveal">
      <div class="gallery-container">
        <img src="../Assets/services/kidney1.jpg" alt="Heart Care">
        <img src="../Assets/services/kidney2.jpeg" alt="Cardiac Monitoring">
        <img src="../Assets/services/kidney3.png" alt="Healthy Lifestyle">
      </div>
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
