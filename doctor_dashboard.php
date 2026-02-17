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
        WHERE a.did = ?
        ORDER BY a.appoint_date ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$total_appointments = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard | E-Channeling</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; background: #f4f7f6; }
        .nav-bar { background: #fff; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .content { padding: 30px 50px; }
        
    
        .alert { padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        
        .stats-bar { margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        th { background: #28a745; color: white; text-transform: uppercase; font-size: 14px; }
        
        .status-Pending { color: #f39c12; font-weight: bold; }
        .status-Confirmed { color: #28a745; font-weight: bold; }
        .status-Cancelled { color: #dc3545; font-weight: bold; }
        
        .btn-action { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; }
        .btn-confirm { color: #28a745; border: 1px solid #28a745; margin-right: 5px; }
        .btn-cancel { color: #dc3545; border: 1px solid #dc3545; }
        
        .btn-home { text-decoration: none; color: #007bff; font-weight: bold; margin-right: 25px; }
        .btn-logout { text-decoration: none; color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>

<div class="nav-bar">
    <div style="font-size: 20px; font-weight: bold; color: #333;">Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></div>
    <div>
        <a href="index.php" class="btn-home">🏠 Home</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="content">
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>

    <div class="stats-bar"><strong>Total Appointments:</strong> <?php echo $total_appointments; ?></div>

    <h2 style="color: #2c3e50; margin-bottom: 20px;">Current Appointment List</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['pname']); ?></td>
                <td><?php echo date('M d, Y', strtotime($row['appoint_date'])); ?></td>
                <td><span class="status-<?php echo $row['appoint_status']; ?>"><?php echo $row['appoint_status']; ?></span></td>
                <td>
                    <?php if($row['appoint_status'] == 'Pending'): ?>
                        <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Confirmed" class="btn-action btn-confirm">Confirm</a>
                        <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Cancelled" class="btn-action btn-cancel">Cancel</a>
                    <?php else: ?>
                        <span style="color: #aaa; font-style: italic;">No actions</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>