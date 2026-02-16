<?php
session_start();
include 'database.php';


if (!isset($_SESSION['patient_id'])) {
    die("Please login as a patient to book an appointment.");
}


$doctor_query = "SELECT did, dname, specialisation, fee FROM Doctors";
$doctors = $conn->query($doctor_query);
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
            <?php while($doc = $doctors->fetch_assoc()): ?>
                <option value="<?php echo $doc['did']; ?>">
                    Dr. <?php echo $doc['dname']; ?> (<?php echo $doc['specialisation']; ?>) - LKR <?php echo $doc['fee']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>

        <label>Appointment Date:</label><br>
        <input type="date" name="appoint_date" min="<?php echo date('Y-m-d'); ?>" required>
        <br><br>

        <button type="submit">Confirm Booking</button>
    </form>
</body>
</html>