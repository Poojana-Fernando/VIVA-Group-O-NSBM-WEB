<?php
session_start();
include 'database.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

// Aggregation pipeline to join appointments with patients and doctors
$pipeline = [
    ['$match' => ['did' => $doctor_id]],
    ['$lookup' => [
        'from' => 'patients',
        'localField' => 'pid',
        'foreignField' => 'pid',
        'as' => 'patient'
    ]],
    ['$unwind' => '$patient'],
    ['$lookup' => [
        'from' => 'doctors',
        'localField' => 'did',
        'foreignField' => 'did',
        'as' => 'doctor'
    ]],
    ['$unwind' => '$doctor'],
    ['$sort' => ['id' => 1]],
    ['$project' => [
        'id' => 1,
        'pname' => '$patient.pname',
        'pemail' => '$patient.email',
        'appoint_date' => 1,
        'appoint_time' => 1,
        'appoint_status' => 1,
        'start_time' => '$doctor.start_time'
    ]]
];

$result = $db->appointments->aggregate($pipeline);
$appointments = iterator_to_array($result);

$slot_duration = 20; 
$count = 0; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard | E-Channeling</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; background: #f4f7f6; }
        
        /* Dashboard Welcome Bar */
        .welcome-bar { 
            background: #fff; 
            padding: 12px 50px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 1px solid var(--border);
        }
        .welcome-bar .doctor-greeting { font-size: 18px; font-weight: bold; color: #333; }
        .welcome-bar .header-links a { 
            text-decoration: none; 
            font-weight: bold; 
            margin-left: 20px; 
            font-size: 16px;
        }
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

        .btn-action { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-block; margin-right: 6px; transition: .2s; }
        .btn-confirm { color: #28a745; border: 1px solid #28a745; }
        .btn-confirm:hover { background: #28a745; color: white; }
        .btn-decline { color: #dc3545; border: 1px solid #dc3545; }
        .btn-decline:hover { background: #dc3545; color: white; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="welcome-bar">
    <div class="doctor-greeting">
        Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?>
    </div>
    <div class="header-links">
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
            <?php foreach($appointments as $row): 
                if (!empty($row['appoint_time'])) {
                    $patient_time = $row['appoint_time'];
                } else {
                    $start = strtotime($row['start_time']);
                    $minutes_to_add = $count * $slot_duration;
                    $patient_time = date('h:i A', strtotime("+$minutes_to_add minutes", $start));
                }
                $count++;
            ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['pname']); ?></td>
                <td><span class="time-badge"><?php echo $patient_time; ?></span></td>
                <td><span class="status-<?php echo $row['appoint_status']; ?>"><?php echo $row['appoint_status']; ?></span></td>
                <td>
                    <?php if($row['appoint_status'] == 'Pending'): ?>
                        <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Confirmed" class="btn-action btn-confirm" onclick="return confirm('Approve this appointment?')">Confirm</a>
                        <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Cancelled" class="btn-action btn-decline" onclick="return confirm('Decline this appointment?')">Decline</a>
                    <?php elseif($row['appoint_status'] == 'Confirmed'): ?>
                        <span style="color: #28a745; font-weight: 600;">✔ Approved</span>
                    <?php elseif($row['appoint_status'] == 'Cancelled'): ?>
                        <span style="color: #dc3545; font-weight: 600;">✖ Declined</span>
                    <?php else: ?>
                        <span style="color: #aaa; font-style: italic;">No actions</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php renderFooter(); ?>
</body>
</html>