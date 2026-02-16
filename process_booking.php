<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pid = $_SESSION['patient_id'];
    $did = $_POST['doctor_id'];
    $date = $_POST['appoint_date'];
    $status = 'Pending';

    $stmt = $conn->prepare("INSERT INTO appointments (pid, did, appoint_date, appoint_status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $pid, $did, $date, $status);

    if ($stmt->execute()) {
        echo "Appointment booked successfully! <a href='patient_dashboard.php'>View My Appointments</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>