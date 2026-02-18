<?php
session_start();
include "database.php";

// Handle status update
if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == "confirm") {
        $sql = "UPDATE appointments SET status='Confirmed' WHERE id='$id'";
        mysqli_query($conn, $sql);
    }

    if ($action == "cancel") {
        $sql = "UPDATE appointments SET status='Cancelled' WHERE id='$id'";
        mysqli_query($conn, $sql);
    }

    header("Location: doctor_dashboard.php");
    exit();
}

// Fetch appointments
$result = mysqli_query($conn, "SELECT * FROM appointments");
?>


<script>
    function confirmAppointment(id) {

    // Hide Confirm button
    document.getElementById("confirmBtn_" + id).style.display = "none";

    // Redirect to PHP to update database
    window.location.href = "doctor_dashboard.php?action=confirm&id=" + id;
}


function cancelAppointment(id) {

    var result = confirm("Are you sure you want to cancel the appointment?");

    if (result) {

        // Hide Cancel button
        document.getElementById("cancelBtn_" + id).style.display = "none";

        // Redirect to PHP to update database
        window.location.href = "doctor_dashboard.php?action=cancel&id=" + id;
    }
}

</script>
</head>

<body>
    <table>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo $row['patient_name']; ?></td>
            <td><?php echo $row['appointment_time']; ?></td>

            <td>
                <?php if ($row['status'] == "Confirmed") { ?>
                    <span class="status-confirmed">Confirmed</span>
                <?php } elseif ($row['status'] == "Cancelled") { ?>
                    <span class="status-cancelled">Cancelled</span>
                <?php } else { ?>
                    Pending
                <?php } ?>
            </td>

            <td>
                <?php if ($row['status'] != "Confirmed") { ?>
                    <button class="btn confirm-btn"
                        onclick="confirmAppointment(<?php echo $row['id']; ?>)">
                        Confirm
                    </button>
                <?php } ?>

                <?php if ($row['status'] != "Cancelled") { ?>
                    <button class="btn cancel-btn"
                        onclick="cancelAppointment(<?php echo $row['id']; ?>)">
                        Cancel
                    </button>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
