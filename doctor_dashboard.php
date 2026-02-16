<?php
session_start();
include 'database.php';

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

// SQL Query to fetch appointments for this specific doctor
// Note: We join with the Patients table to get the name instead of just the ID
$sql = "SELECT a.id, p.pname, a.appoint_date, a.appoint_status 
        FROM appointments a 
        JOIN Patients p ON a.pid = p.pid 
        WHERE a.did = ?
        ORDER BY a.appoint_date ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard | E-Channeling</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; background: #f4f7f6; }
        .nav-bar { background: #fff; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .content { padding: 30px 50px; }
        
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        th { background: #28a745; color: white; font-weight: 600; text-transform: uppercase; font-size: 14px; }
        
        .status-Pending { color: #f39c12; font-weight: bold; }
        .status-Confirmed { color: #28a745; font-weight: bold; }
        
        .btn-home { text-decoration: none; color: #007bff; font-weight: bold; margin-right: 25px; display: flex; align-items: center; }
        .btn-logout { text-decoration: none; color: #dc3545; font-weight: bold; }
        .header-links { display: flex; align-items: center; }
    </style>
</head>
<body>

<div class="nav-bar">
    <div style="font-size: 20px; font-weight: bold; color: #333;">
        Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?>
    </div>
    <div class="header-links">
        <a href="index.php" class="btn-home">🏠 Home</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="content">
    <h2 style="color: #2c3e50; margin-bottom: 20px;">Current Appointment List</h2>
    
    <?php if($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><strong>#<?php echo $row['id']; ?></strong></td>
                <td><?php echo htmlspecialchars($row['pname']); ?></td>
                <td><?php echo date('M d, Y', strtotime($row['appoint_date'])); ?></td>
                <td>
                    <span class="status-<?php echo $row['appoint_status']; ?>">
                        <?php echo $row['appoint_status']; ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div style="background: white; padding: 40px; text-align: center; border-radius: 10px; color: #888;">
            <p>No appointments found yet. New bookings will appear here.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>