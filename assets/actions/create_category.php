<?php
/** @var PDO $pdo */
$pdo = require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$sql = "INSERT INTO `categories`(`name`) VALUES (:category)";
$stmt = $pdo->prepare($sql);
$stmt->execute(["category" => $_POST['category']]);

header('Location: /add_product.php');