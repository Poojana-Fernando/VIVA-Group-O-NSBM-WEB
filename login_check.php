<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['demail'];
    $password = $_POST['dpassword'];

    
    $stmt = $conn->prepare("SELECT did, dname, password FROM Doctors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();


        if ($password === $row['password']) {
            $_SESSION['doctor_id'] = $row['did'];
            $_SESSION['doctor_name'] = $row['dname'];
            header("Location: doctor_dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Incorrect Email.";
    }
    $stmt->close();
}
?>