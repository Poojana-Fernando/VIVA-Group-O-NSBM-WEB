<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Channeling | Home</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; color: #333; line-height: 1.6; background-color: #f8f9fa; }
        .navbar { background: #fff; padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; text-decoration: none; }
        .nav-links a { margin-left: 20px; text-decoration: none; color: #666; font-weight: 500; }
        
        .hero { padding: 80px 20px; text-align: center; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; }
        .hero h1 { font-size: 42px; margin-bottom: 10px; }
        
        .cta-section { display: flex; justify-content: center; gap: 20px; margin-top: -40px; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        
        .btn { display: inline-block; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; transition: 0.3s; border: none; cursor: pointer; }
        .btn-book { background: #007bff; color: white; }
        .btn-doc { background: #28a745; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        
        .section { padding: 60px 50px; max-width: 1000px; margin: auto; }
        footer { background: #333; color: white; text-align: center; padding: 30px; margin-top: 50px; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php" class="logo">E-Channeling</a>
    <div class="nav-links">
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <?php if(isset($_SESSION['doctor_id'])): ?>
            <a href="doctor_dashboard.php" style="color: #28a745; font-weight: bold;">Dashboard</a>
        <?php else: ?>
            <a href="doctor_login.html">Doctor Login</a>
        <?php endif; ?>
    </div>
</div>

<div class="hero">
    <h1>Your Health, Simplified.</h1>
    <p>Connecting patients with top medical specialists instantly.</p>
</div>

<div class="cta-section">
    <div class="card">
        <h3>Need a Doctor?</h3>
        <p>Quick booking for all patients. No registration required.</p>
        <a href="book_now.php" class="btn btn-book">Book Now</a>
    </div>
    
    <div class="card">
        <h3>Doctor Portal</h3>
        <p>Manage your upcoming appointments and patient list.</p>
        <?php if(isset($_SESSION['doctor_id'])): ?>
            <a href="doctor_dashboard.php" class="btn btn-doc">Go to Dashboard</a>
        <?php else: ?>
            <a href="doctor_login.html" class="btn btn-doc">Doctor Login</a>
        <?php endif; ?>
    </div>
</div>

<div id="about" class="section">
    <h2>About Us</h2>
    <p>E-Channeling is a modern healthcare platform built to eliminate long queues. Whether you are a student like me or a busy professional, our system ensures getting care is as easy as a single click.</p>
</div>

<div id="contact" class="section" style="background: #fff; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
    <h2>Contact Us</h2>
    <p><strong>Email:</strong> support@e-channeling.lk</p>
    <p><strong>Phone:</strong> +94 11 234 5678</p>
    <p><strong>Location:</strong> Colombo, Sri Lanka</p>
</div>

<footer>
    <p>&copy; 2026 E-Channeling System. All Rights Reserved.</p>
</footer>

</body>
</html>