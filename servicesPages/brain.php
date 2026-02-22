<?php
session_start();
$basePath = '../';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Brain & Spine | NSBM Healthcare</title>
  <link rel="stylesheet" href="../servicestyle.css" />

</head>

<body>

  <?php include '../navbar.php'; ?>

  <header class="top-banner">
    <img src="../Assets/services/slide2.jpg" alt="Brain and Spine Centre Banner">
  </header>

  <main class="page reveal">
    <section class="service-box reveal">
      <h1>Brain & Spine</h1>
      <p>
  Our Brain and Spine Care Clinic supports students and staff with assessments for
  common neurological and spine-related concerns, plus guidance for safer daily habits.
</p>

<ul>
  <li>Headache / migraine initial assessment</li>
  <li>Back and neck pain evaluation (posture and strain-related)</li>
  <li>Numbness / tingling symptom screening</li>
  <li>Referral for imaging or specialist care when needed</li>
</ul>
    </section>
    <section class="image-gallery reveal">
      <div class="gallery-container">
        <img src="../Assets/services/brain1.jpg" alt="Heart Care">
        <img src="../Assets/services/brain2.jpg" alt="Cardiac Monitoring">
        <img src="../Assets/services/brain3.jpg" alt="Healthy Lifestyle">
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
