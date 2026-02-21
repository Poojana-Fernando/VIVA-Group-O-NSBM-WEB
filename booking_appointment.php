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
    <title>Book Appointment | NSBM Healthcare</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        .booking-content { max-width: 700px; margin: 40px auto; padding: 0 20px; }
        .booking-content h1 { font-size: 28px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 700; font-size: 14px; margin-bottom: 6px; color: var(--text); }
        .form-group select, .form-group input {
            width: 100%; padding: 11px 12px; border-radius: 12px;
            border: 1px solid var(--border); outline: none; font-size: 14px; background: #fff;
        }
        .form-group select:focus, .form-group input:focus {
            border-color: rgba(34, 197, 94, .45);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, .12);
        }
        .btn-submit {
            background: var(--green); color: #fff; padding: 11px 24px;
            border: 0; border-radius: 999px; font-weight: 800; cursor: pointer;
            transition: .2s; box-shadow: 0 10px 20px rgba(34, 197, 94, .18); margin-top: 10px;
        }
        .btn-submit:hover { background: var(--green-dark); transform: translateY(-1px); }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="booking-content">
        <h1>Book an Appointment</h1>
        <form action="process_booking.php" method="POST">
            <div class="form-group">
                <label>Select Doctor:</label>
                <select name="doctor_id" required>
                    <option value="">-- Choose a Doctor --</option>
                    <?php foreach($doctors as $doc): ?>
                        <option value="<?php echo $doc['did']; ?>">
                            Dr. <?php echo $doc['dname']; ?> (<?php echo $doc['specialisation']; ?>) - LKR <?php echo $doc['fee']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Appointment Date:</label>
                <input type="date" name="appoint_date" min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <button type="submit" class="btn-submit">Confirm Booking</button>
        </form>
    </div>

    <?php renderFooter(); ?>
</body>
</html>