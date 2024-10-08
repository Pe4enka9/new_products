<?php
session_start();
/** @var PDO $pdo */
$pdo = require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

try {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $published = isset($_POST['published']) ? 1 : 0;

    $addProduct = "INSERT INTO `products`(`name`, `description`, `categories_id`, `published`) VALUES (:name, :description, :category, :published)";
    $stmt = $pdo->prepare($addProduct);
    $stmt->execute([
        "name" => $name,
        "description" => $description,
        "category" => $category,
        "published" => $published,
    ]);

    if (empty($_POST['image'])) {
        $image = null;
    } else {
        $image = $_POST['image'];
    }

    $addImage = "INSERT INTO `images`(`products_id`, `image`) VALUES (:products_id, :image)";
    $stmt = $pdo->prepare($addImage);
    $stmt->execute([
        "products_id" => $pdo->lastInsertId(),
        "image" => $image,
    ]);

    $_SESSION['sqlError'] = "<div class='success'>Товар успешно добавлен!</div>";
} catch (PDOException $e) {
    $_SESSION['sqlError'] = "<div class='error'>Не удалось добавить товар!</div>";
    setcookie('name', $name, path: '/add_product.php');
    setcookie('description', $description, path: '/add_product.php');
    setcookie('category', $category, path: '/add_product.php');
    setcookie('image', $image, path: '/add_product.php');
}

header('Location: /add_product.php');