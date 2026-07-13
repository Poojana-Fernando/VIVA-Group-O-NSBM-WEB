<?php
/**
 * API Endpoint: Check Doctor Availability
 * GET ?did=<doctor_id>&date=<YYYY-MM-DD>
 * Returns JSON with booked time slots for the given doctor and date.
 */
header('Content-Type: application/json');
include 'database.php';

$did = isset($_GET['did']) ? (int)$_GET['did'] : 0;
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (!$did || !$date) {
    echo json_encode(['error' => 'Missing did or date parameter']);
    exit;
}

// Get doctor's start time
$doc = $db->doctors->findOne(
    ['did' => $did],
    ['projection' => ['start_time' => 1, 'dname' => 1]]
);

if (!$doc) {
    echo json_encode(['error' => 'Doctor not found']);
    exit;
}

// Get all appointments for this doctor on this date
$appointments = $db->appointments->find([
    'did' => $did,
    'appoint_date' => $date
]);

$booked_times = [];
foreach ($appointments as $appt) {
    if (isset($appt['appoint_time'])) {
        // New-flow bookings store the time directly
        $booked_times[] = $appt['appoint_time'];
    }
}

// Also calculate legacy position-based times (for old bookings without appoint_time)
$slot_duration = 20;
$start_time = isset($doc['start_time']) ? $doc['start_time'] : '08:00';
$position = 0;

foreach ($db->appointments->find(['did' => $did, 'appoint_date' => $date]) as $appt) {
    if (!isset($appt['appoint_time'])) {
        $minutes = $position * $slot_duration;
        $legacy_time = date('h:i A', strtotime("+$minutes minutes", strtotime($start_time)));
        $booked_times[] = $legacy_time;
    }
    $position++;
}

// Remove duplicates
$booked_times = array_values(array_unique($booked_times));

echo json_encode([
    'booked_times' => $booked_times,
    'doctor_name' => isset($doc['dname']) ? $doc['dname'] : '',
    'start_time' => $start_time
]);
?>
