<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pname = $_POST['pname'];
    $pemail = $_POST['pemail'];
    $did = $_POST['did'];
    $date = $_POST['appoint_date'];

    // Getting Patient ID (finding the existing one, or create new)
    $stmt = $conn->prepare("SELECT pid FROM Patients WHERE email = ?");
    $stmt->bind_param("s", $pemail);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $pid = $res->fetch_assoc()['pid'];
    } else {
        $stmt = $conn->prepare("INSERT INTO Patients (pname, email, contact) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $pname, $pemail, $_POST['pcontact']);
        $stmt->execute();
        $pid = $conn->insert_id;
    }

    //Get Doctor Info & Calculate Time Slot
    $doc_stmt = $conn->prepare("SELECT dname, specialisation, start_time FROM Doctors WHERE did = ?");
    $doc_stmt->bind_param("i", $did);
    $doc_stmt->execute();
    $doc = $doc_stmt->get_result()->fetch_assoc();

    $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE did = ? AND appoint_date = ?");
    $count_stmt->bind_param("is", $did, $date);
    $count_stmt->execute();
    $position = $count_stmt->get_result()->fetch_assoc()['total'];

    //Doctor's Start Time + (Queue Position * 20 minutes)
    $patient_time = date('h:i A', strtotime("+" . ($position * 20) . " minutes", strtotime($doc['start_time'])));

    // Saving the Appointment
    $book = $conn->prepare("INSERT INTO appointments (pid, did, appoint_date, appoint_status) VALUES (?, ?, ?, 'Pending')");
    $book->bind_param("iis", $pid, $did, $date);

    if ($book->execute()) {
        $booking_id = $conn->insert_id;
        // Display the receipt
?>
        <!DOCTYPE html>
        <html>
        <body style="font-family: Arial, sans-serif; background: #f4f7f6; text-align: center; padding: 50px;">
            <div style="background: white; padding: 30px; border: 1px solid #ccc; max-width: 400px; margin: auto; border-radius: 10px;">
                <h2 style="color: #28a745;">✔ Booking Confirmed!</h2>
                
                <div style="text-align: left; margin: 20px 0; line-height: 1.8;">
                    <b>Booking ID:</b> #<?= $booking_id ?><br>
                    <b>Patient:</b> <?= htmlspecialchars($pname) ?><br>
                    <b>Doctor:</b> Dr. <?= $doc['dname'] ?> (<?= $doc['specialisation'] ?>)<br>
                    <b>Date:</b> <?= $date ?><br>
                </div>

                <div style="background: #e8f0fe; padding: 15px; font-size: 20px; font-weight: bold; color: #1967d2; border-radius: 5px;">
                    Time: <?= $patient_time ?>
                </div>

                <br><br>
                <a href="generate_pdf.php?id=<?= $booking_id ?>" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 10px;">Download PDF Ticket</a>
                <br>
                <a href="index.php" style="color: #007bff; text-decoration: none;">Return to Home</a>
            </div>
        </body>
        </html>
<?php
    } else {
        echo "Error processing booking: " . $conn->error;
    }
}
?>