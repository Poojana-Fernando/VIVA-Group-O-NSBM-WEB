<?php
require_once __DIR__ . '/db.php';

// GET /api/doctors.php?search=...&specialization=...
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$specialization = isset($_GET['specialization']) ? trim($_GET['specialization']) : '';

$query = 'SELECT * FROM doctors';
$conditions = [];
$params = [];
$types = '';

if ($search !== '') {
    $conditions[] = 'dname LIKE ?';
    $searchParam = '%' . $search . '%';
    $params[] = &$searchParam;
    $types .= 's';
}

if ($specialization !== '') {
    $conditions[] = 'specialization = ?';
    $params[] = &$specialization;
    $types .= 's';
}

if (count($conditions) > 0) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

$stmt = $conn->prepare($query);

if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

echo json_encode($doctors);

$stmt->close();
$conn->close();
