<?php
require_once __DIR__ . '/api/db.php';
header('Content-Type: text/html; charset=utf-8');

$message = '';
$messageClass = '';

// Handle Appointment Booking (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientName = isset($_POST['patientName']) ? trim($_POST['patientName']) : '';
    $email       = isset($_POST['email'])       ? trim($_POST['email'])       : '';
    $phone       = isset($_POST['phone'])       ? trim($_POST['phone'])       : '';
    $doctorId    = isset($_POST['doctorId'])    ? (int) $_POST['doctorId']    : 0;
    $appointDate = isset($_POST['appointDate']) ? trim($_POST['appointDate']) : '';

    if ($patientName === '' || $email === '' || $phone === '' || $doctorId === 0 || $appointDate === '') {
        $message = 'Please fill in all required fields.';
        $messageClass = 'error';
    } else {
        $conn->begin_transaction();
        try {
            // Check if patient exists
            $stmt = $conn->prepare('SELECT pid FROM Patients WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $patientId = $result->fetch_assoc()['pid'];
            } else {
                // Create new patient
                $defaultPassword = 'temp1234';
                $stmtInsert = $conn->prepare('INSERT INTO Patients (pname, email, ppassword, contact) VALUES (?, ?, ?, ?)');
                $stmtInsert->bind_param('ssss', $patientName, $email, $defaultPassword, $phone);
                $stmtInsert->execute();
                $patientId = $stmtInsert->insert_id;
                $stmtInsert->close();
            }
            $stmt->close();

            // Insert Appointment
            $status = 'Pending';
            $stmtAppt = $conn->prepare('INSERT INTO appointments (pid, did, appoint_date, appoint_status) VALUES (?, ?, ?, ?)');
            $stmtAppt->bind_param('iiss', $patientId, $doctorId, $appointDate, $status);
            $stmtAppt->execute();
            $appointmentId = $stmtAppt->insert_id;
            $stmtAppt->close();

            $conn->commit();

            $reference = 'APT-' . str_pad($appointmentId, 5, '0', STR_PAD_LEFT);
            $message = "✅ Appointment booked! Reference: <strong>$reference</strong>";
            $messageClass = 'success';
        } catch (Exception $e) {
            $conn->rollback();
            $message = '❌ Booking failed. Please try again.';
            if ($conn->errno === 1062) {
                $message = '❌ A patient with this email already exists.';
            }
            $messageClass = 'error';
        }
    }
}

// Fetch Specializations
$specsResult = $conn->query('SELECT DISTINCT specialization FROM doctors ORDER BY specialization');
$specializations = [];
while ($row = $specsResult->fetch_assoc()) {
    $specializations[] = $row['specialization'];
}

// Fetch Doctors with Filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$specFilter = isset($_GET['specialization']) ? trim($_GET['specialization']) : '';

$query = "SELECT * FROM doctors WHERE 1=1";
$params = [];
$types = "";

if ($search) {
    $query .= " AND dname LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}
if ($specFilter) {
    $query .= " AND specialization = ?";
    $params[] = $specFilter;
    $types .= "s";
}

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$doctorsResult = $stmt->get_result();
$doctors = [];
while ($row = $doctorsResult->fetch_assoc()) {
    $doctors[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NSBM Healthcare — e-Channelling</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="container header-inner">
      <h1>🏥 NSBM Healthcare</h1>
      <nav>
        <a href="#doctors">Doctors</a>
        <a href="#booking">Book Appointment</a>
      </nav>
    </div>
  </header>

  <!-- Doctors Section -->
  <section id="doctors" class="container">
    <h2>Our Doctors</h2>
    
    <!-- Search Form (GET) -->
    <form method="GET" action="index.php" class="filters">
      <input type="text" name="search" placeholder="Search doctor name..." value="<?= htmlspecialchars($search) ?>">
      <select name="specialization">
        <option value="">All Specializations</option>
        <?php foreach ($specializations as $spec): ?>
            <option value="<?= htmlspecialchars($spec) ?>" <?= $spec === $specFilter ? 'selected' : '' ?>>
                <?= htmlspecialchars($spec) ?>
            </option>
        <?php endforeach; ?>
      </select>
      <button type="submit">Filter</button>
    </form>

    <div id="doctor-list" class="card-grid">
      <?php if (count($doctors) > 0): ?>
        <?php foreach ($doctors as $doc): ?>
            <div class="doctor-card">
              <h3><?= htmlspecialchars($doc['dname']) ?></h3>
              <p class="specialty"><?= htmlspecialchars($doc['specialization']) ?></p>
              <p class="details">
                Fee: Rs. <?= number_format($doc['fee']) ?>
                <?php if (!empty($doc['present_days'])): ?>
                    <br>Available: <?= htmlspecialchars($doc['present_days']) ?>
                <?php endif; ?>
              </p>
            </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="no-results">No doctors found matching your criteria.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Booking Section -->
  <section id="booking" class="container">
    <h2>Book an Appointment</h2>
    <form method="POST" action="index.php#booking" class="form-card">
      <div class="form-row">
        <div class="form-group">
          <label for="doctor-select">Doctor *</label>
          <select id="doctor-select" name="doctorId" required>
            <option value="">Select a doctor</option>
            <?php 
            // We need a fresh list of ALL doctors for the booking dropdown, 
            // irrespective of the search filters above.
            $allDoctors = $conn->query("SELECT * FROM doctors ORDER BY dname");
            while ($d = $allDoctors->fetch_assoc()): 
            ?>
                <option value="<?= $d['did'] ?>">
                    <?= htmlspecialchars($d['dname']) ?> — <?= htmlspecialchars($d['specialization']) ?>
                </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="appoint-date">Date *</label>
          <input type="date" id="appoint-date" name="appointDate" required min="<?= date('Y-m-d') ?>">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="patient-name">Patient Name *</label>
          <input type="text" id="patient-name" name="patientName" required placeholder="Full name">
        </div>
        <div class="form-group">
          <label for="patient-email">Email *</label>
          <input type="email" id="patient-email" name="email" required placeholder="you@example.com">
        </div>
      </div>
      <div class="form-group">
        <label for="patient-phone">Phone *</label>
        <input type="tel" id="patient-phone" name="phone" required placeholder="+94 XX XXX XXXX">
      </div>
      
      <button type="submit">Book Appointment</button>

      <?php if ($message): ?>
          <div id="form-message" class="<?= $messageClass ?>" style="display: block;">
              <?= $message ?>
          </div>
      <?php endif; ?>
    </form>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2026 NSBM Healthcare — e-Channelling System</p>
    </div>
  </footer>

</body>
</html>
