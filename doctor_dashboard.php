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
    <title>Doctor Dashboard | E-Channeling</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; background: #f4f7f6; }
        .nav-bar { background: #fff; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .content { padding: 30px 50px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        th, td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #28a745; color: white; }
        .status-Pending { color: #f39c12; font-weight: bold; }
        .btn-home { text-decoration: none; color: #007bff; font-weight: bold; margin-right: 20px; }
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
    <h2>Current Appointment List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>