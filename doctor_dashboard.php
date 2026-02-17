<?php
session_start();
include 'database.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

$sql = "SELECT a.id, p.pname, a.appoint_date, a.appoint_status, d.start_time 
        FROM appointments a 
        JOIN Patients p ON a.pid = p.pid 
        JOIN Doctors d ON a.did = d.did
        WHERE a.did = ?
        ORDER BY a.id ASC"; 

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$slot_duration = 20; 
$count = 0; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard | E-Channeling</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; background: #f4f7f6; }
        
        /* Restored Navigation Bar Styles */
        .nav-bar { 
            background: #fff; 
            padding: 15px 50px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }
        .header-links a { 
            text-decoration: none; 
            font-weight: bold; 
            margin-left: 20px; 
            font-size: 16px;
        }
        .btn-home { color: #007bff; }
        .btn-logout { color: #dc3545; }

        /* Table & Content Styles */
        .content { padding: 30px 50px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        th { background: #28a745; color: white; font-size: 15px; }
        
        .time-badge { background: #e8f0fe; color: #1967d2; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 13px; }
        
        .status-Pending { color: #f39c12; font-weight: bold; }
        .status-Confirmed { color: #28a745; font-weight: bold; }
        .status-Cancelled { color: #dc3545; font-weight: bold; }

        .btn-action { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; }
        .btn-confirm { color: #28a745; border: 1px solid #28a745; }
        .btn-confirm:hover { background: #28a745; color: white; }
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
    <h2>Today's Schedule & Times</h2>
    
    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <strong><?php echo htmlspecialchars($_GET['msg']); ?></strong>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Patient Name</th>
                <th>Scheduled Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): 
                $start = strtotime($row['start_time']);
                $minutes_to_add = $count * $slot_duration;
                $patient_time = date('h:i A', strtotime("+$minutes_to_add minutes", $start));
                $count++;
            ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['pname']); ?></td>
                <td><span class="time-badge"><?php echo $patient_time; ?></span></td>
                <td><span class="status-<?php echo $row['appoint_status']; ?>"><?php echo $row['appoint_status']; ?></span></td>
                <td>
                    <?php if($row['appoint_status'] == 'Pending'): ?>
                        <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Confirmed" class="btn-action btn-confirm">Confirm</a>
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