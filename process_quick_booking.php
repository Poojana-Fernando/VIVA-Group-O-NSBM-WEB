<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pname = $_POST['pname'];
    $pemail = $_POST['pemail'];
    $pcontact = $_POST['pcontact'];
    $did = $_POST['did'];
    $date = $_POST['appoint_date'];

    // 1. Check if patient already exists
    $check = $conn->prepare("SELECT pid FROM Patients WHERE email = ?");
    $check->bind_param("s", $pemail);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pid = $row['pid'];
    } else {
        // 2. Register them automatically if new
        $ins = $conn->prepare("INSERT INTO Patients (pname, email, contact) VALUES (?, ?, ?)");
        $ins->bind_param("sss", $pname, $pemail, $pcontact);
        $ins->execute();
        $pid = $conn->insert_id; // Gets the new AUTO_INCREMENT pid
    }

    // 3. Create the Appointment
    $book = $conn->prepare("INSERT INTO appointments (pid, did, appoint_date) VALUES (?, ?, ?)");
    $book->bind_param("iis", $pid, $did, $date);

    if ($book->execute()) {
        echo "<h1>Booking Successful!</h1>";
        echo "<p>Your Appointment ID is: " . $conn->insert_id . "</p>";
        echo "<a href='index.php'>Return to Home</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>