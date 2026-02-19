<?php
session_start();
include 'database.php';

// Checking if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

// Fetching appointments
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard | Appointment Schedule</title>
    <style>
        /* Modern CSS Styles */
        :root {
            --primary: #10b981;
            --primary-hover: #059669;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body { 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            margin: 0; 
            background: var(--bg); 
            color: var(--text-main);
        }

        .nav { 
            background: #ffffff; 
            padding: 1rem 2rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .nav span { font-weight: 600; color: var(--text-main); }
        .nav a { text-decoration: none; font-size: 14px; font-weight: 500; }

        .content { padding: 40px 2rem; max-width: 1100px; margin: 0 auto; }
        
        h2 { margin-bottom: 1.5rem; font-weight: 700; color: #0f172a; }

        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        
        th { 
            background: #f1f5f9; 
            color: var(--text-muted); 
            font-weight: 600; 
            text-transform: uppercase; 
            font-size: 12px; 
            letter-spacing: 0.05em;
            padding: 16px;
            text-align: left;
        }

        td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        tr:last-child td { border-bottom: none; }

        /* Status Badges */
        .badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .confirmed { background: #dcfce7; color: #166534; }
        .cancelled { background: #fee2e2; color: #991b1b; }
        .pending { background: #fef9c3; color: #854d0e; }

        /* Buttons */
        .btn { 
            padding: 6px 14px; 
            text-decoration: none; 
            border-radius: 6px; 
            font-size: 13px; 
            font-weight: 600; 
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            border: 1px solid transparent;
        }
        .confirm { background: var(--primary); color: white; margin-right: 8px; }
        .confirm:hover { background: var(--primary-hover); }
        
        .cancel { border-color: #e2e8f0; color: var(--danger); background: white; }
        .cancel:hover { background: #fff1f2; border-color: #fecaca; }

        /* Modal Overlay */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; top: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }

        /* Modal Content Box */
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            width: 100%;
            max-width: 400px;
            position: relative;
            text-align: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .close-icon {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            color: var(--text-muted);
            cursor: pointer;
            line-height: 1;
        }
        .close-icon:hover { color: var(--text-main); }

        .modal h3 { margin-top: 0; color: var(--text-main); }
        .modal p { color: var(--text-muted); margin-bottom: 2rem; }

        .modal-buttons { display: flex; gap: 12px; justify-content: center; }
        
        .modal-buttons button {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }

        .confirm-btn { background: var(--danger); color: white; }
        .confirm-btn:hover { background: var(--danger-hover); }

        .close-btn { background: #f1f5f9; color: var(--text-main); }
        .close-btn:hover { background: #e2e8f0; }

    </style>
</head>
<body>

<div class="nav">
    <span>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></span>
    <div>
        <a href="index.php" style="margin-right:20px; color: var(--text-muted);">Home</a>
        <a href="logout.php" style="color:var(--danger)">Logout</a>
    </div>
</div>

<div class="content">
    <h2>Appointment Schedule</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Scheduled Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): 
                    $start = strtotime($row['start_time']);
                    $patient_time = date('h:i A', strtotime("+".($count * $slot_duration)." minutes", $start));
                    $status = $row['appoint_status'];
                    $count++;
                ?>
                <tr>
                    <td style="font-weight: 600; color: var(--text-muted);">#<?php echo $row['id']; ?></td>
                    <td style="font-weight: 500;"><?php echo htmlspecialchars($row['pname']); ?></td>
                    <td><?php echo $patient_time; ?></td>
                    <td>
                        <?php
                        if ($status == "Confirmed") {
                            echo '<span class="badge confirmed">Confirmed</span>';
                        } elseif ($status == "Cancelled") {
                            echo '<span class="badge cancelled">Cancelled</span>';
                        } else {
                            echo '<span class="badge pending">Pending</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($status !== "Confirmed"): ?>
                            <a href="update_status.php?id=<?php echo $row['id']; ?>&status=Confirmed" class="btn confirm">Confirm</a>
                        <?php endif; ?>
                        
                        <a href="#" class="btn cancel" onclick="openModal(<?php echo $row['id']; ?>); return false;">Cancel</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="cancelModal" class="modal">
    <div class="modal-content">
        <span class="close-icon" onclick="closeModal()">&times;</span>
        <h3>Cancel Appointment</h3>
        <p>Are you sure you want to cancel this appointment? This action cannot be undone.</p>
        <div class="modal-buttons">
            <button class="confirm-btn" onclick="proceedCancel()">Yes, Cancel</button>
            <button class="close-btn" onclick="closeModal()">No, Keep it</button>
        </div>
    </div>
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
    if(selectedId) {
        window.location.href = "update_status.php?id=" + selectedId + "&status=Cancelled";
    }
}

// Close modal if user clicks outside of the box
window.onclick = function(event) {
    let modal = document.getElementById("cancelModal");
    if (event.target == modal) {
        closeModal();
    }
}
</script>

</body>
</html>