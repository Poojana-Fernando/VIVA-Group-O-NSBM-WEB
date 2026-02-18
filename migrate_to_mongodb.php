<?php
/**
 * One-time MySQL → MongoDB Data Migration Script
 * 
 * Run this ONCE in your browser: http://localhost/VIVA-Group-O-NSBM-WEB/migrate_to_mongodb.php
 * It will copy all data from MySQL to MongoDB and set up indexes + counters.
 */

// --- MySQL Connection (source) ---
$mysql = new mysqli("localhost", "root", "", "E-channeling");
if ($mysql->connect_error) {
    die("<p style='color:red;'>MySQL connection failed: " . $mysql->connect_error . "</p>");
}

// --- MongoDB Connection (destination) ---
require_once __DIR__ . '/vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->e_channeling;

echo "<h1>MySQL → MongoDB Migration</h1>";
echo "<hr>";

// --- Step 1: Migrate Doctors ---
echo "<h2>1. Migrating Doctors...</h2>";
$doctors_result = $mysql->query("SELECT * FROM Doctors");
$doctor_count = 0;
$max_did = 0;

// Drop existing collection to avoid duplicates on re-run
$db->doctors->drop();

while ($row = $doctors_result->fetch_assoc()) {
    $did = (int)$row['did'];
    $fee = (float)$row['fee'];
    
    $db->doctors->insertOne([
        'did' => $did,
        'dname' => $row['dname'],
        'specialisation' => $row['specialisation'],
        'fee' => $fee,
        'present_days' => $row['present_days'],
        'email' => $row['email'],
        'password' => $row['password'],
        'start_time' => isset($row['start_time']) ? $row['start_time'] : '09:00:00'
    ]);
    $doctor_count++;
    if ($did > $max_did) $max_did = $did;
}
echo "<p>✅ Migrated <strong>$doctor_count</strong> doctors.</p>";

// --- Step 2: Migrate Patients ---
echo "<h2>2. Migrating Patients...</h2>";
$patients_result = $mysql->query("SELECT * FROM Patients");
$patient_count = 0;
$max_pid = 0;

$db->patients->drop();

while ($row = $patients_result->fetch_assoc()) {
    $pid = (int)$row['pid'];

    $doc = [
        'pid' => $pid,
        'pname' => $row['pname'],
        'email' => $row['email'],
        'contact' => $row['contact'],
        'created_at' => new MongoDB\BSON\UTCDateTime(strtotime($row['created_at']) * 1000)
    ];
    
    // Include password if it exists
    if (isset($row['password']) && !empty($row['password'])) {
        $doc['password'] = $row['password'];
    }

    $db->patients->insertOne($doc);
    $patient_count++;
    if ($pid > $max_pid) $max_pid = $pid;
}
echo "<p>✅ Migrated <strong>$patient_count</strong> patients.</p>";

// --- Step 3: Migrate Appointments ---
echo "<h2>3. Migrating Appointments...</h2>";
$appt_result = $mysql->query("SELECT * FROM appointments");
$appt_count = 0;
$max_appt_id = 0;

$db->appointments->drop();

while ($row = $appt_result->fetch_assoc()) {
    $id = (int)$row['id'];

    $db->appointments->insertOne([
        'id' => $id,
        'pid' => (int)$row['pid'],
        'did' => (int)$row['did'],
        'appoint_date' => $row['appoint_date'],
        'appoint_status' => $row['appoint_status']
    ]);
    $appt_count++;
    if ($id > $max_appt_id) $max_appt_id = $id;
}
echo "<p>✅ Migrated <strong>$appt_count</strong> appointments.</p>";

// --- Step 4: Set up Counters for Auto-Increment ---
echo "<h2>4. Setting up Auto-Increment Counters...</h2>";
$db->counters->drop();
$db->counters->insertMany([
    ['_id' => 'doctors', 'seq' => $max_did],
    ['_id' => 'patients', 'seq' => $max_pid],
    ['_id' => 'appointments', 'seq' => $max_appt_id]
]);
echo "<p>✅ Counters set: doctors=$max_did, patients=$max_pid, appointments=$max_appt_id</p>";

// --- Step 5: Create Indexes ---
echo "<h2>5. Creating Indexes...</h2>";
$db->doctors->createIndex(['email' => 1], ['unique' => true]);
$db->doctors->createIndex(['did' => 1], ['unique' => true]);
$db->patients->createIndex(['email' => 1], ['unique' => true]);
$db->patients->createIndex(['pid' => 1], ['unique' => true]);
$db->appointments->createIndex(['id' => 1], ['unique' => true]);
$db->appointments->createIndex(['did' => 1, 'appoint_date' => 1]);
echo "<p>✅ Indexes created on email, did, pid, and appointment id fields.</p>";

// --- Done ---
$mysql->close();
echo "<hr>";
echo "<h2 style='color: green;'>🎉 Migration Complete!</h2>";
echo "<p>Total: <strong>$doctor_count</strong> doctors, <strong>$patient_count</strong> patients, <strong>$appt_count</strong> appointments.</p>";
echo "<p><a href='index.php'>← Return to Home</a></p>";
?>
