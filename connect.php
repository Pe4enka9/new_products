<?php

$host = "MySQL-8.2";
$dbname = "docker_prod";
$username = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$dbname";

try {
    return $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}