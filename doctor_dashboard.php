<?php
session_start();
include 'database.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];


$sql = "SELECT a.id, p.pname, a.appoint_date, a.appoint_status 
        FROM appointments a 
        JOIN Patients p ON a.pid = p.pid 
        WHERE a.did = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .status-Pending { color: orange; }
        .status-Confirmed { color: green; }
    </style>
</head>
<body>
    <h1>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></h1>
    <a href="logout.php">Logout</a>

    <h2>Your Appointments</h2>
    <table>
        <tr>
            <th>Appointment ID</th>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['pname']); ?></td>
            <td><?php echo $row['appoint_date']; ?></td>
            <td class="status-<?php echo $row['appoint_status']; ?>">
                <?php echo $row['appoint_status']; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>