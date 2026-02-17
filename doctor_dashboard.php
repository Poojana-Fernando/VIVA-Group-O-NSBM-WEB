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
        
        .time-badge { background: #e8f0fe; color: #1967d2; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 13px; }
    </style>
</head>
<body>
<div class="content">
    <h2>Today's Schedule & Times</h2>
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
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>