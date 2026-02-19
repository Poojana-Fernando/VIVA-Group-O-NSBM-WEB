<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/mongo_helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new MongoDB\Client($_ENV['MONGODB_URI']);
$db = $client->selectDatabase($_ENV['DB_NAME']);

// Connection successful
?>