<?php
session_start();
/** @var PDO $pdo */
$pdo = require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$login = $_POST['login'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM `users` WHERE login = :login AND password = :password AND isAdmin = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "login" => $login,
    "password" => $password,
]);

if ($stmt->rowCount() > 0) {
    $_SESSION['admin'] = $login;
} else {
    $_SESSION['adminError'] = "<div class='error'>Неверный логин или пароль!</div>";
    setcookie("login", $login, path: '/admin.php');
}
header("Location: /admin.php");