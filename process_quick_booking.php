<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pname = $_POST['pname'];
    $pemail = $_POST['pemail'];
    $pcontact = $_POST['pcontact'];
    $did = $_POST['did'];
    $date = $_POST['appoint_date'];

    // 1. Patient Handling (Check if exists, or create new)
    $check = $conn->prepare("SELECT pid FROM Patients WHERE email = ?");
    $check->bind_param("s", $pemail);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pid = $row['pid'];
    } else {
        // Register new patient automatically
        $ins = $conn->prepare("INSERT INTO Patients (pname, email, contact) VALUES (?, ?, ?)");
        $ins->bind_param("sss", $pname, $pemail, $pcontact);
        $ins->execute();
        $pid = $conn->insert_id;
    }

    // 2. Queue and Time Slot Calculation
    // Count how many people booked before this person for the same doctor and date
    $count_query = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE did = ? AND appoint_date = ?");
    $count_query->bind_param("is", $did, $date);
    $count_query->execute();
    $position = $count_query->get_result()->fetch_assoc()['total'];

    // Fetch Doctor details for the receipt
    $doc_query = $conn->prepare("SELECT dname, specialisation, start_time FROM Doctors WHERE did = ?");
    $doc_query->bind_param("i", $did);
    $doc_query->execute();
    $doc = $doc_query->get_result()->fetch_assoc();

    // Calculate time: Start Time + (Position * 20 mins)
    $slot_duration = 20;
    $minutes_to_add = $position * $slot_duration;
    $patient_time = date('h:i A', strtotime("+$minutes_to_add minutes", strtotime($doc['start_time'])));

    // 3. Insert the Appointment into the database
    $book = $conn->prepare("INSERT INTO appointments (pid, did, appoint_date, appoint_status) VALUES (?, ?, ?, 'Pending')");
    $book->bind_param("iis", $pid, $did, $date);

    if ($book->execute()) {
        $booking_id = $conn->insert_id;
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Booking Confirmed | E-Channeling</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
                .receipt-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 450px; border-top: 10px solid #007bff; }
                .success-icon { font-size: 50px; color: #28a745; text-align: center; margin-bottom: 10px; }
                h2 { text-align: center; color: #333; margin-top: 0; }
                .detail-group { margin: 20px 0; border-top: 1px solid #eee; padding-top: 20px; }
                .row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; }
                .label { color: #777; }
                .value { font-weight: bold; color: #333; }
                .time-slot { background: #e8f0fe; color: #1967d2; text-align: center; padding: 15px; border-radius: 10px; font-size: 22px; font-weight: bold; margin: 25px 0; }
                .btn { display: block; text-align: center; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-bottom: 10px; transition: 0.3s; }
                .btn-pdf { background: #28a745; color: white; }
                .btn-home { background: #f0f0f0; color: #333; }
                .btn:hover { opacity: 0.9; transform: translateY(-1px); }
            </style>
        </head>
        <body>

        <div class="receipt-card">
            <div class="success-icon">✔</div>
            <h2>Booking Confirmed!</h2>
            <p style="text-align: center; color: #666;">Please keep this receipt for your records.</p>

            <div class="detail-group">
                <div class="row"><span class="label">Booking ID:</span> <span class="value">#<?php echo $booking_id; ?></span></div>
                <div class="row"><span class="label">Patient:</span> <span class="value"><?php echo htmlspecialchars($pname); ?></span></div>
                <div class="row"><span class="label">Doctor:</span> <span class="value">Dr. <?php echo $doc['dname']; ?></span></div>
                <div class="row"><span class="label">Specialization:</span> <span class="value"><?php echo $doc['specialisation']; ?></span></div>
                <div class="row"><span class="label">Date:</span> <span class="value"><?php echo date('l, M d, Y', strtotime($date)); ?></span></div>
            </div>

            <div class="time-slot">
                Scheduled Time: <?php echo $patient_time; ?>
            </div>

            <a href="generate_pdf.php?id=<?php echo $booking_id; ?>" class="btn btn-pdf">Download PDF Ticket</a>
            <a href="index.php" class="btn btn-home">Return to Home</a>
            
            <p style="text-align: center; font-size: 12px; color: #999; margin-top: 20px;">
                Note: Please arrive 15 minutes before your time slot.
            </p>
        </div>

        </body>
        </html>
        <?php
    } else {
        echo "<div style='color: red; padding: 20px;'>Error processing booking: " . $conn->error . "</div>";
    }
}
?>