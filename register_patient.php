<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['pname'];
    $email = $_POST['pemail'];
    $contact = $_POST['pcontact'];

    
    $stmt = $conn->prepare("INSERT INTO Patients (pname, email, contact) VALUES (?, ?, ?)");
    
    if ($stmt === false) {
        die("Query Preparation Failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $contact);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='index.php'>Return to Home</a>";
    } else {
        echo "Execution Failed: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>