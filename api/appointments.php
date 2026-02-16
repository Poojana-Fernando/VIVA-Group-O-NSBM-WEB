<?php
require_once __DIR__ . '/db.php';

// POST /api/appointments.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Read JSON body
$input = json_decode(file_get_contents('php://input'), true);

$patientName = isset($input['patientName']) ? trim($input['patientName']) : '';
$email       = isset($input['email'])       ? trim($input['email'])       : '';
$phone       = isset($input['phone'])       ? trim($input['phone'])       : '';
$doctorId    = isset($input['doctorId'])     ? (int) $input['doctorId']    : 0;
$appointDate = isset($input['appointDate'])  ? trim($input['appointDate']) : '';

// Validate required fields
if ($patientName === '' || $email === '' || $phone === '' || $doctorId === 0 || $appointDate === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields: patientName, email, phone, doctorId, appointDate']);
    exit;
}

// Begin transaction
$conn->begin_transaction();

try {
    // Check if patient already exists by email
    $stmt = $conn->prepare('SELECT pid FROM Patients WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Patient exists — use their ID
        $row = $result->fetch_assoc();
        $patientId = $row['pid'];
    } else {
        // Insert new patient (default password since booking form doesn't collect it)
        $defaultPassword = 'temp1234';
        $stmtInsert = $conn->prepare('INSERT INTO Patients (pname, email, ppassword, contact) VALUES (?, ?, ?, ?)');
        $stmtInsert->bind_param('ssss', $patientName, $email, $defaultPassword, $phone);
        $stmtInsert->execute();
        $patientId = $stmtInsert->insert_id;
        $stmtInsert->close();
    }
    $stmt->close();

    // Insert the appointment
    $status = 'Pending';
    $stmtAppt = $conn->prepare('INSERT INTO appointments (pid, did, appoint_date, appoint_status) VALUES (?, ?, ?, ?)');
    $stmtAppt->bind_param('iiss', $patientId, $doctorId, $appointDate, $status);
    $stmtAppt->execute();
    $appointmentId = $stmtAppt->insert_id;
    $stmtAppt->close();

    // Commit transaction
    $conn->commit();

    $reference = 'APT-' . str_pad($appointmentId, 5, '0', STR_PAD_LEFT);

    http_response_code(201);
    echo json_encode([
        'message'       => 'Appointment booked successfully',
        'appointmentId' => $appointmentId,
        'patientId'     => $patientId,
        'reference'     => $reference
    ]);

} catch (Exception $e) {
    $conn->rollback();

    if ($conn->errno === 1062) {
        // Duplicate entry
        http_response_code(409);
        echo json_encode(['error' => 'A patient with this email already exists with different details.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to book appointment']);
    }
}

$conn->close();
