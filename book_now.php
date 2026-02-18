<?php
require 'database.php';
$doctors = $conn->query("SELECT did, dname, specialisation, fee FROM Doctors")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quick Book</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 20px auto; line-height: 1.6; }
        input, select, button { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; }
        button { background: #007bff; color: #fff; border: none; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <form action="process_quick_booking.php" method="POST">
        <h2>Quick Appointment</h2>
        
        <input type="text" name="pname" placeholder="Full Name" required>
        <input type="email" name="pemail" placeholder="Email Address" required>
        <input type="text" name="pcontact" placeholder="Contact Number" required>

        <hr>

        <select name="did" required>
            <option value="">-- Select Specialist --</option>
            <?php foreach ($doctors as $d): ?>
                <option value="<?= $d['did'] ?>">
                    Dr. <?= "{$d['dname']} ({$d['specialisation']}) - LKR {$d['fee']}" ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="appoint_date" min="<?= date('Y-m-d') ?>" required>

        <button type="submit">Confirm Booking</button>
    </form>
</body>
</html>