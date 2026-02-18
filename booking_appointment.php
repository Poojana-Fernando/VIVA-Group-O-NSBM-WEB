<?php
session_start();
include 'database.php';


if (!isset($_SESSION['patient_id'])) {
    die("Please login as a patient to book an appointment.");
}


$doctors = $db->doctors->find([], ['projection' => ['did' => 1, 'dname' => 1, 'specialisation' => 1, 'fee' => 1]]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
</head>
<body>
    <h1>Book an Appointment</h1>
    <form action="process_booking.php" method="POST">
        <label>Select Doctor:</label><br>
        <select name="doctor_id" required>
            <option value="">-- Choose a Doctor --</option>
            <?php foreach($doctors as $doc): ?>
                <option value="<?php echo $doc['did']; ?>">
                    Dr. <?php echo $doc['dname']; ?> (<?php echo $doc['specialisation']; ?>) - LKR <?php echo $doc['fee']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Appointment Date:</label><br>
        <input type="date" name="appoint_date" min="<?php echo date('Y-m-d'); ?>" required>
        <br><br>

        <button type="submit">Confirm Booking</button>
    </form>
</body>
</html>