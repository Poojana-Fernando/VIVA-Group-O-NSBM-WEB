<?php
session_start();
include 'database.php';

// checking if the the doctore is logged in or not, if not then redirect to the login page.
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

// getting all the appointments from the database.
$sql = "SELECT a.id, p.pname, a.appoint_date, a.appoint_status, d.start_time 
        FROM appointments a 
        JOIN Patients p ON a.pid = p.pid 
        JOIN Doctors d ON a.did = d.did
        WHERE a.did = ? ORDER BY a.id ASC"; 

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
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f7f6; }
        .nav { background: #fff; padding: 15px; display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; }
        .navbar
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 15px; overflow: hidden; border-radius: 8px 8px 0 0;}
        th, td { padding: 12px; border: 1px solid #eee; text-align: left; }
        th { background: #28a745; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; transition: opacity 0.2s;}
        .btn:hover { opacity: 0.8; }
        .confirm { border: 1px solid green; color: green; }
        .cancel { border: 1px solid red; color: red; }
        .card {background-color: #fff; padding: 15px 20px; border-radius:8px; display:flex; align-items: center; transition: transform 0.2s; justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 15px;}
        .badge {padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block;}
        .confirmed {background-color: #28a745; color: white;}
        .cancelled {background-color: #dc3545; color: white;}
        .pending {background-color: #ffc107; color: black;}

</style>
</head>
<body>

<div class="nav">
    <span>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></span>
    <div>
        <a href="index.php" style="margin-right:15px">Home</a>
        <a href="logout.php" style="color:red">Logout</a>
    </div>
</div>

<div class="content">
    <h2>Appointment Schedule</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): 
            $start = strtotime($row['start_time']);
            $patient_time = date('h:i A', strtotime("+".($count * $slot_duration)." minutes", $start));
            $count++;
        ?>
        <tr>

            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['pname']); ?></td>
            <td><?php echo $patient_time; ?></td>
            <td>
                <?php
                $status = $row['appoint_status'];
                if ($status == "Confirmed") {
                    echo '<span class="badge confirmed">Confirmed</span>';
                    }
                    elseif ($status == "Cancelled") {
                        echo '<span class="badge cancelled">Cancelled</span>';
                        }
                        else {
                            echo '<span class="badge pending">Pending</span>';
                            }
                            ?>
            </td>

            <td>
                <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Confirmed" class="btn confirm"onclick="this.style.display='none';">Confirm</a>
                <a href="#" class="btn cancel"onclick="openModal(<?php echo $row['id']; ?>); return false;">Cancel</a>

            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<script>

let selectedId = null;

function openModal(id) {
    selectedId = id;
    document.getElementById("cancelModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("cancelModal").style.display = "none";
}

function proceedCancel() {
    window.location.href = "update_status.php?id=" + selectedId + "&status=Cancelled";
}

</script>

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="modal">
    <div class="modal-content">

        <span class="close-icon" onclick="closeModal()">&times;</span>

        <h3>Cancel Appointment</h3>
        <p>Are you sure you want to cancel this appointment?</p>

        <div class="modal-buttons">
            <button class="confirm-btn" onclick="proceedCancel()">Yes, Cancel</button>
            <button class="close-btn" onclick="closeModal()">No</button>
        </div>

    </div>
</div>


</body>
</html>