<?php if(!isset($basePath)) $basePath = ''; ?>
<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>

<div class="navbar">
    <a href="<?= $basePath ?>index.php" class="nsbm-logo">
        <img src="<?= $basePath ?>Assets/logo.png" alt="nsbm-logo">
    </a>

    <div class="nav-links">
        <a href="<?= $basePath ?>index.php#about">About</a>
        <a href="<?= $basePath ?>index.php#contact">Contact</a>
    </div>

    <div class="nav-actions">
        <a href="<?= $basePath ?>book_now.php" class="btn btn-book nav-btn">Book Now</a>

        <?php if(isset($_SESSION['doctor_id'])): ?>
        <a href="<?= $basePath ?>doctor_dashboard.php" class="btn btn-doc nav-btn">Dashboard</a>
        <?php else: ?>
        <a href="<?= $basePath ?>doctor_login.php" class="btn btn-doc nav-btn">Doctor Portal</a>
        <?php endif; ?>
    </div>
</div>

<?php
function renderFooter() {
    global $basePath;
    if(!isset($basePath)) $basePath = '';
?>
<footer class="site-footer">
  <div class="footer-container">
    
    <div class="footer-col brand-col">
      <img src="<?= $basePath ?>Assets/logo.png" alt="NSBM Healthcare Logo" class="footer-logo">
      <p class="footer-desc">
        Providing safe, reliable, and student-friendly healthcare to ensure you stay healthy, focused, and confident throughout your academic journey.
      </p>
    </div>

    <div class="footer-col">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="<?= $basePath ?>index.php">Home</a></li>
        <li><a href="<?= $basePath ?>index.php#about">About Us</a></li>
        <li><a href="<?= $basePath ?>index.php#doctors">Our Doctors</a></li>
        <li><a href="<?= $basePath ?>book_now.php">Book Appointment</a></li>
        <li><a href="<?= $basePath ?>doctor_login.php">Doctor Portal</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Departments</h3>
      <ul>
        <li><a href="<?= $basePath ?>servicesPages/heart.php">Heart Centre</a></li>
        <li><a href="<?= $basePath ?>servicesPages/brain.php">Brain &amp; Spine</a></li>
        <li><a href="<?= $basePath ?>servicesPages/kidney.php">Kidney Care</a></li>
        <li><a href="<?= $basePath ?>servicesPages/general.php">General Clinic</a></li>
      </ul>
    </div>

    <div class="footer-col contact-col">
      <h3>Contact Us</h3>
      <ul>
        <li>
          <strong>Location:</strong>
          NSBM Green University, Homagama, Sri Lanka
        </li>
        <li>
          <strong>Phone:</strong>
          +94 11 234 5678
        </li>
        <li>
          <strong>Email:</strong>
          nsbmhealthcare@nsbm.lk
        </li>
      </ul>
    </div>

  </div>

  <div class="footer-bottom">
    <p>&copy; <?php echo date("Y"); ?> NSBM Healthcare E-Channeling System. All Rights Reserved.</p>
    <div class="footer-legal">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
    </div>
  </div>
  <?php include __DIR__ . '/chatbot.php'; ?>
</footer>
<?php } ?>
