<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pid = $_SESSION['patient_id'];
    $did = (int)$_POST['doctor_id'];
    $date = $_POST['appoint_date'];
    $status = 'Pending';

    $appointment_id = getNextSequence($db, 'appointments');

    $result = $db->appointments->insertOne([
        'id' => $appointment_id,
        'pid' => $pid,
        'did' => $did,
        'appoint_date' => $date,
        'appoint_status' => $status
    ]);

    if ($result->getInsertedCount() > 0) {
        echo "Appointment booked successfully! <a href='patient_dashboard.php'>View My Appointments</a>";
    } else {
        echo "Error processing booking.";
    }
}
?>