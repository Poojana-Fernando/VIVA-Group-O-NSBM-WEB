<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Channeling System | Home</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; text-align: center; padding: 50px; background-color: #f4f7f6; }
        .hero { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 800px; margin: auto; }
        .container { display: flex; justify-content: center; gap: 30px; margin-top: 40px; flex-wrap: wrap; }
        .card { background: #fff; border: 1px solid #eee; padding: 30px; width: 280px; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .btn { display: inline-block; padding: 15px 30px; background-color: #007bff; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s; }
        .btn:hover { background-color: #0056b3; transform: translateY(-2px); }
        .btn-doctor { background-color: #28a745; }
        .btn-doctor:hover { background-color: #218838; }
        h1 { color: #2c3e50; }
        p { color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Welcome to E-Channeling</h1>
        <p>Providing seamless healthcare connections for you and your family.</p>

        <div class="container">
            <div class="card">
                <h3>Patients</h3>
                <p>No account needed. Just fill in your details and pick your doctor.</p>
                <a href="book_now.php" class="btn">Book an Appointment</a>
            </div>

            <div class="card">
                <h3>Doctors</h3>
                <p>Access your private dashboard to manage patient sessions.</p>
                <a href="doctor_login.html" class="btn btn-doctor">Doctor Login</a>
            </div>
        </div>
    </div>
</body>
</html>