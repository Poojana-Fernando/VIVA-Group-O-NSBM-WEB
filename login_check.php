<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['demail'];
    $password = $_POST['dpassword'];

    $doctor = $db->doctors->findOne(['email' => $email]);

    if ($doctor) {
        if ($password === $doctor['password']) {
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