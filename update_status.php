<?php
session_start();
include 'database.php';

if (!isset($_SESSION['doctor_id'])) {
    exit("Unauthorized access.");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $appointment_id = (int)$_GET['id'];
    $new_status = $_GET['status'];
    $doctor_id = $_SESSION['doctor_id'];

    $result = $db->appointments->updateOne(
        ['id' => $appointment_id, 'did' => $doctor_id],
        ['$set' => ['appoint_status' => $new_status]]
    );

    if ($result->getModifiedCount() > 0 || $result->getMatchedCount() > 0) {
        header("Location: doctor_dashboard.php?msg=Appointment " . $new_status . " successfully!");
        exit();
    } else {
        echo "Error: Appointment not found or not authorized.";
    }
}
?>