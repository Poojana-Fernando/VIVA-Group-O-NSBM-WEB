<?php
session_start();
include 'database.php';

if (!isset($_SESSION['doctor_id'])) {
    exit("Unauthorized access.");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $appointment_id = $_GET['id'];
    $new_status = $_GET['status'];
    $doctor_id = $_SESSION['doctor_id'];

    $stmt = $conn->prepare("UPDATE appointments SET appoint_status = ? WHERE id = ? AND did = ?");
    $stmt->bind_param("sii", $new_status, $appointment_id, $doctor_id);

    if ($stmt->execute()) {
        
        header("Location: doctor_dashboard.php?msg=Appointment " . $new_status . " successfully!");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>