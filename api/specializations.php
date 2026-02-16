<?php
require_once __DIR__ . '/db.php';

// GET /api/specializations.php
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$result = $conn->query('SELECT DISTINCT specialization FROM doctors ORDER BY specialization');

$specializations = [];
while ($row = $result->fetch_assoc()) {
    $specializations[] = $row['specialization'];
}

echo json_encode($specializations);

$conn->close();
