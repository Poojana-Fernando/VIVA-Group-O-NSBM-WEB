<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/mongo_helpers.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->e_channeling;

// Connection successful
?>