<?php

$url = parse_url(getenv('CLEARDB_DATABASE_URL'));


$dbName = substr($url['path'], 1);
$dbUser = $url['user'];
$dbPass = $url['pass'];
$dbHost = $url['host'];

try {
    $conn = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName, $dbUser, $dbPass);
} catch (PDOException $err) {
    echo 'Database connection problem: ' . $err->getMessage();
}
