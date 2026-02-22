<?php
session_start();
$basePath = '../';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>General Clinic | NSBM Healthcare</title>
  <link rel="stylesheet" href="../servicestyle.css" />


</head>

<body>

  <?php include '../navbar.php'; ?>

  <header class="top-banner">
    <img src="../Assets/services/slide4.jpg" alt="General Clinic Banner">
  </header>

  <main class="page reveal">
    <section class="service-box reveal">
      <h1>General Clinic</h1>
      <p>
  Our General Clinic supports students and staff with general medical consultations,
  basic health screening, and guidance for a healthier lifestyle.
</p>

<ul>
  <li>Blood pressure and pulse checks</li>
  <li>Chest pain / palpitations initial assessment</li>
  <li>Health advice: diet, exercise, stress management</li>
  <li>Referrals to specialist care when needed</li>
</ul>
    </section>

    <section class="image-gallery reveal">
      <div class="gallery-container">
        <img src="../Assets/services/clinic1.jpg" alt="Heart Care">
        <img src="../Assets/services/clinic2.jpg" alt="Cardiac Monitoring">
        <img src="../Assets/services/clinic3.jpg" alt="Healthy Lifestyle">
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
