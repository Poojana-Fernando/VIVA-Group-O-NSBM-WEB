<?php
require 'database.php';
$doctors = $conn->query("SELECT did, dname, specialisation, fee FROM Doctors")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quick Book</title>
    <style>
       
    
    body {
        background-color: #ffffff;
        font-family: 'Poppins', sans-serif;
    }
    .navbar {
        display: block;
        align-items: center;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

    .container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }

    form {
        background: #eeeeee;
        max-width: 550px;
        margin: 60px auto;
        padding: 45px 55px;
        border-radius: 24px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.07);
    }

    form h2 {
        text-align: center;
        font-weight: 700;
        color: #1e293b;
        margin-top: 0;
        margin-bottom: 35px;
        font-size: 28px;
    }

    form label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="tel"],
    form input[type="number"],
    form input[type="date"],
    form select {
        width: 100%;
        padding: 16px 20px;
        margin-bottom: 25px;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        font-size: 15px;
        color: #334155;
        font-family: inherit;
        background-color: #fdfdfd;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    form input:focus,
    form select:focus {
        outline: none;
        border-color: #328d2f;
        background-color: #fff;
        box-shadow: 0 0 0 4px #328d2f;
    }

    form select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 16px center;
        background-repeat: no-repeat;
        background-size: 20px 20px;
    }

    form button[type="submit"] {
        width: 100%;
        padding: 18px;
        margin-top: 10px;
        background: #328d2f;
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        background: #328d2f;
        box-shadow: 0 10px 25px #328d2f;
    }

    form button[type="submit"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px ;
        background: #328d2f;
    }
    /* Smooth scrolling for links */
    html {
      scroll-behavior: smooth;
    }
    /* Base reveal state */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.8s ease-out;
    }
    /* State when visible on screen */
    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }
    .nsbm-logo {
      display: flex;
      height: 30px;
      align-items: center;
      justify-content: center;
    }
    .nsbm-logo img {
      height: 120px;
      width: auto;
      display: block;
      object-fit: contain;
    }
    .appointment-card {
      background: #ffffff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 450px;
      margin: auto;
      text-align: center; /* Centers the heading and inline elements */
    }
    .logo-container {
      margin-bottom: 20px; /* Space between logo and "Quick Appointment" text */
      display: flex;
      justify-content: center;
    }
    .form-logo {
      width: 150px; /* Adjust size as needed */
      height: auto;
    }
    h2 {
      color: #1a237e; /* Matches your dark blue text */
      margin-bottom: 25px;
      font-family: sans-serif;
    }
    </style>
    
</head>
<body>

       <div class="navbar">
    <a href="index.php" class="nsbm-logo">
        <img src="Assets/logo.png" alt="nsbm-logo">
    </a>
    <form action="process_quick_booking.php" method="POST" class="reveal">
        <h2>Quick Appointment</h2>
        
        <input type="text" name="pname" placeholder="Full Name" required>
        <input type="email" name="pemail" placeholder="Email Address" required>
        <input type="text" name="pcontact" placeholder="Contact Number" required>

        <hr>

        <select name="did" required>
            <option value="">-- Select Specialist --</option>
            <?php foreach ($doctors as $d): ?>
                <option value="<?= $d['did'] ?>">
                    Dr. <?= "{$d['dname']} ({$d['specialisation']}) - LKR {$d['fee']}" ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="appoint_date" min="<?= date('Y-m-d') ?>" required>

        <button type="submit">Confirm Booking</button>
    </form>
    <script>
document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".reveal");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        // add animation class when visible
        entry.target.classList.add("active");
      } else {
        // remove it when not visible (so it can animate again)
        entry.target.classList.remove("active");
      }
    });
  }, { threshold: 0.15 });

  items.forEach((el) => observer.observe(el));
});
</script>
</body>
</html>