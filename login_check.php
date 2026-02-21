<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validate the Email
    $email = trim($_POST['demail']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format."); // if the email is wrong, stop the process.
    }

    $password = $_POST['dpassword'];

    // getting doctor details from the database
    $doctor = $db->doctors->findOne(['email' => $email]);

    if ($doctor) {
        $storedPassword = $doctor['password'];
        $passwordMatch = false;

        // First try bcrypt verification (for hashed passwords)
        if (password_verify($password, $storedPassword)) {
            $passwordMatch = true;
        }
        // Fallback: direct comparison for plaintext passwords (from migration)
        elseif ($password === $storedPassword) {
            $passwordMatch = true;

            // Auto-upgrade: hash the plaintext password for future security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $db->doctors->updateOne(
                ['email' => $email],
                ['$set' => ['password' => $hashedPassword]]
            );
        }

        if ($passwordMatch) {
            $_SESSION['doctor_id'] = $doctor['did'];
            $_SESSION['doctor_name'] = $doctor['dname'];
            header("Location: doctor_dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Incorrect Email.";
    }
}
?>