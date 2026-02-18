<?php
session_start();
require 'database.php';

if (!isset($_SESSION['patient_id'])) die("Access denied. Please login.");

// Fetch doctors 
$doctors = $conn->query("SELECT did, dname, specialisation, fee FROM Doctors")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head><title>Book Appointment</title></head>
<body>
    <h1>Book an Appointment</h1>
    <form action="process_booking.php" method="POST">
        <label>Select Doctor:</label><br>
        <select name="doctor_id" required>
            <option value="">-- Choose --</option>
            <?php foreach ($doctors as $doc): ?>
                <option value="<?= $doc['did'] ?>">
                    Dr. <?= "{$doc['dname']} ({$doc['specialisation']}) - LKR {$doc['fee']}" ?>
                </option>
            <?php endforeach; ?>
        </select>

        <p>Appointment Date:<br>
        <input type="date" name="appoint_date" min="<?= date('Y-m-d') ?>" required></p>

        <button type="submit">Confirm Booking</button>
    </form>
</body>
</html>