<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSBM E-Channeling System | Health at Your Fingertips</title>
    <style>
        /* General Styles */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; color: #333; line-height: 1.6; }
        header { background: #007bff; color: white; padding: 1rem 0; text-align: center; }
        nav { background: #f4f4f4; padding: 10px; text-align: center; sticky: top; }
        nav a { margin: 0 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        
        /* Hero Section */
        .hero { background: #e9ecef; padding: 60px 20px; text-align: center; }
        
        /* Layout Sections */
        section { padding: 40px 20px; max-width: 1000px; margin: auto; }
        .container { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
        
        /* Cards */
        .card { border: 1px solid #ddd; padding: 25px; width: 250px; border-radius: 12px; transition: 0.3s; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .card:hover { transform: translateY(-5px); }
        .btn { display: inline-block; padding: 12px 25px; margin: 5px; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn-patient { background-color: #007bff; }
        .btn-doctor { background-color: #28a745; }
        
        /* Footer */
        footer { background: #333; color: white; text-align: center; padding: 20px 0; margin-top: 40px; }
        .contact-info { font-style: normal; }
    </style>
</head>
<body>

<header>
    <h1>NSBM E-Channeling </h1>
</header>

<nav>
    <a href="#home">Home</a>
    <a href="#about">About Us</a>
    <a href="#portals">Portals</a>
    <a href="#contact">Contact Us</a>
</nav>

<div id="home" class="hero">
    <h2>Book Your Consultant Online</h2>
    <p>Skip the queue and schedule your appointment with top specialists in minutes.</p>
</div>

<section id="portals">
    <h2 style="text-align:center;">Access Portals</h2>
    <div class="container">
        <div class="card">
            <h3>For Patients</h3>
            <p>Find doctors, check availability, and book appointments instantly.</p>
            <a href="patient_register.html" class="btn btn-patient">Register</a>
            <a href="patient_login.html" class="btn btn-patient" style="background: #555;">Login</a>
        </div>

        <div class="card">
            <h3>For Doctors</h3>
            <p>Manage your daily schedule and view patient medical requests.</p>
            <a href="doctor_login.html" class="btn btn-doctor">Doctor Dashboard</a>
        </div>
    </div>
</section>

<section id="about" style="background: #f9f9f9; border-radius: 15px;">
    <h2>About Our System</h2>
    <p>
        The E-Channeling System is a digital healthcare platform designed to bridge the gap between patients and healthcare providers. 
        Whether you are at home or on the go, our system allows you to manage your health schedule with transparency and ease.
    </p>
    <ul>
        <li><strong>Real-time Booking:</strong> Instant confirmation of appointments.</li>
        <li><strong>Specialist Search:</strong> Filter doctors by specialization and fee.</li>
        <li><strong>Secure Data:</strong> Your medical information and privacy are our priority.</li>
    </ul>
</section>

<section id="contact">
    <h2>Contact Us</h2>
    <div class="container" style="justify-content: space-between; align-items: flex-start;">
        <div style="flex: 1;">
            <p>Have questions? Reach out to our support team.</p>
            <address class="contact-info">
                <strong>Email:</strong> support@e-channeling.com<br>
                <strong>Phone:</strong> +94 11 234 5678<br>
                <strong>Address:</strong> 123 Health Ave, Colombo, Sri Lanka
            </address>
        </div>
        <div style="flex: 1; text-align: right;">
            <p>Stay updated with our latest medical news and services by following our social channels.</p>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2026 E-Channeling System. All Rights Reserved.</p>
</footer>

</body>
</html>