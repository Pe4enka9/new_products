<?php
session_start();
/** @var PDO $pdo */
$pdo = require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$categories = $pdo->query("SELECT * FROM `categories`")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/assets/icons/admin.png" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <title>Добавить товар</title>
</head>
<body>

<form action="/assets/actions/create_product.php" method="post" id="add-product">
    <h2>Добавить товар</h2>

    <div class="wrapper">
        <input type="text" name="name" id="name" placeholder="Название" value="<?php
        echo $_COOKIE['name'] ?? '';
        setcookie("name", "", time() - 3600, '/add_product.php');
        ?>">
    </div>

    <div class="wrapper">
        <textarea name="description" id="description" placeholder="Описание"><?php
            if (isset($_COOKIE['description'])) {
                echo $_COOKIE['description'];
                setcookie("description", "", time() - 3600, '/add_product.php');
            }
            ?></textarea>
    </div>

    <div class="wrapper">
        <select name="category" id="category">
            <?php if (isset($_COOKIE['category'])): ?>
                <?php foreach ($categories as $category): ?>
                    <?php if ($category['id'] == $_COOKIE['category']): ?>
                        <option value="<?php
                        echo $_COOKIE['category'];
                        setcookie("category", "", time() - 3600, '/add_product.php');
                        ?>" selected hidden><?= $category['name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="all" selected hidden>Категория</option>
            <?php endif; ?>

            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <a href="#" id="add-category">Добавить категорию</a>
    </div>

    <div class="wrapper">
        <input type="text" name="image" id="image" placeholder="Путь к изображению">
    </div>

    <div class="wrapper" id="published-wrapper">
        <input type="checkbox" name="published" id="published">
        <label for="published">Опубликовать</label>
    </div>

    <?php
    echo $_SESSION['sqlError'] ?? '';
    unset($_SESSION['sqlError']);
    ?>

    <input type="submit" id="btn" value="Добавить" disabled>

    <a href="/admin.php">&laquo; Назад</a>
</form>

<form action="/assets/actions/create_category.php" method="post" id="modal">
    <div class="modal-wrapper">
        <h2>Добавить категорию</h2>

        <input type="text" name="category" id="category-name" placeholder="Название">
        <input type="submit" id="add-category-btn" value="Добавить" disabled>

        <a href="#" id="close-modal">Закрыть</a>
    </div>
</form>

<script src="/assets/js/add_product.js"></script>
</body>
</html>