<?php
session_start();
include 'database.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $doctor_id = $_SESSION['doctor_id'];


    $stmt = $conn->prepare("UPDATE appointments SET appoint_status = ? WHERE id = ? AND did = ?");
    $stmt->bind_param("sii", $status, $id, $doctor_id);

    if ($stmt->execute()) {
        header("Location: doctor_dashboard.php?msg=Status Updated");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
?>