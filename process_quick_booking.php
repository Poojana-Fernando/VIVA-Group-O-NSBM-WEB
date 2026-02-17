<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pname = $_POST['pname'];
    $pemail = $_POST['pemail'];
    $pcontact = $_POST['pcontact'];
    $did = $_POST['did'];
    $date = $_POST['appoint_date'];

   
    $check = $conn->prepare("SELECT pid FROM Patients WHERE email = ?");
    $check->bind_param("s", $pemail);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pid = $row['pid'];
    } else {
        $ins = $conn->prepare("INSERT INTO Patients (pname, email, contact) VALUES (?, ?, ?)");
        $ins->bind_param("sss", $pname, $pemail, $pcontact);
        $ins->execute();
        $pid = $conn->insert_id;
    }


    $count_query = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE did = ? AND appoint_date = ?");
    $count_query->bind_param("is", $did, $date);
    $count_query->execute();
    $count_res = $count_query->get_result()->fetch_assoc();
    $position = $count_res['total']; 

    
    $doc_query = $conn->prepare("SELECT start_time FROM Doctors WHERE did = ?");
    $doc_query->bind_param("i", $did);
    $doc_query->execute();
    $doc_data = $doc_query->get_result()->fetch_assoc();
    $start_time = $doc_data['start_time'];

    
    $slot_duration = 20;
    $minutes_to_add = $position * $slot_duration;
    $assigned_time = date('h:i A', strtotime("+$minutes_to_add minutes", strtotime($start_time)));

    
    $book = $conn->prepare("INSERT INTO appointments (pid, did, appoint_date) VALUES (?, ?, ?)");
    $book->bind_param("iis", $pid, $did, $date);

    if ($book->execute()) {
        echo "<div style='font-family: Arial; text-align: center; padding: 50px;'>";
        echo "<h1 style='color: #28a745;'>Booking Successful!</h1>";
        echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 10px; display: inline-block;'>";
        echo "<h3>Appointment Details</h3>";
        echo "<p><strong>Patient:</strong> $pname</p>";
        echo "<p><strong>Date:</strong> $date</p>";
        echo "<p style='font-size: 20px; color: #007bff;'><strong>Your Time: $assigned_time</strong></p>";
        echo "<p><small>Please arrive 15 minutes early.</small></p>";
        echo "</div><br><br>";
        echo "<a href='index.php' style='text-decoration: none; color: #666;'>Return to Home</a>";
        echo "</div>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>