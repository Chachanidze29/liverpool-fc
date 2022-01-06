<?php

$dbName = 'abcd0001';
$dbUser = 'root';
$dbPass = '';
$dbHost = 'localhost';

try {
    $conn = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName, $dbUser, $dbPass);
} catch (PDOException $err) {
    echo 'Database connection problem: ' . $err->getMessage();
}
