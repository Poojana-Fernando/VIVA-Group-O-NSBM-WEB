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
    $stmt = $conn->prepare("SELECT did, dname, password FROM Doctors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // secure Password Verification
        // use password_verify() instead of '==='
        if (password_verify($password, $row['password'])) {
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