<?php
include 'database.php';
// doctors
$doctors = $db->doctors->find([], ['projection' => ['did' => 1, 'dname' => 1, 'specialisation' => 1, 'fee' => 1]]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book an Appointment</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .btn { background: #007bff; color: white; padding: 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Quick Appointment Booking</h1>
    <form action="process_quick_booking.php" method="POST">
        <h3>Step 1: Your Details</h3>
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="pname" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="pemail" required>
        </div>
        <div class="form-group">
            <label>Contact Number:</label>
            <input type="text" name="pcontact" required>
        </div>

        <hr>

        <h3>Step 2: Appointment Details</h3>
        <div class="form-group">
            <label>Select Doctor:</label>
            <select name="did" required>
                <option value="">-- Choose Specialist --</option>
                <?php foreach($doctors as $doc): ?>
                    <option value="<?php echo $doc['did']; ?>">
                        Dr. <?php echo $doc['dname']; ?> (<?php echo $doc['specialisation']; ?>) - LKR <?php echo $doc['fee']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Preferred Date:</label>
            <input type="date" name="appoint_date" min="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit" class="btn">Confirm Booking</button>
    </form>
</body>
</html>