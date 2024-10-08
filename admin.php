<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
/** @var PDO $pdo */
$pdo = require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$products = $pdo->query(
    "SELECT products.id, products.name, products.description, products.categories_id, products.published, MIN(images.image) AS first_image
FROM images JOIN products
ON products.id = images.products_id
GROUP BY products.id;"
)->fetchAll(PDO::FETCH_ASSOC);

$categories = $pdo->query("SELECT * FROM `categories`")->fetchAll(PDO::FETCH_ASSOC);
$currentCategory = $_GET['category'] ?? 'all';
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
    <title>Админ панель</title>
</head>
<body>

<?php if (!isset($_SESSION['admin'])): ?>
    <form action="/assets/actions/admin_login.php" method="post">
        <h1>Админ панель</h1>

        <div class="wrapper">
            <input type="text" name="login" id="login" value="<?php
            echo $_COOKIE['login'] ?? '';
            setcookie("login", "", time() - 3600, '/admin.php');
            ?>" placeholder="Логин">
        </div>

        <div class="wrapper">
            <input type="password" name="password" id="password" placeholder="Пароль">
        </div>

        <?php
        echo $_SESSION['adminError'] ?? '';
        unset($_SESSION['adminError']);
        ?>

        <input type="submit" id="btn" value="Войти" disabled>
    </form>
<?php else: ?>
    <h1>Админ панель</h1>
    <a href="/add_product.php">Добавить товар</a>
    <a href="/assets/actions/admin_logout.php">Выйти</a>

    <div class="container">
        <h1>Каталог</h1>

        <form method="get">
            <select name="category">
                <option value="all" selected>Все</option>
                <?php foreach ($categories as $category): ?>
                    <?php if ($currentCategory == $category['id']): ?>
                        <option value="<?= $currentCategory ?>" selected><?= $category['name'] ?></option>
                    <?php else: ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Искать">
        </form>

        <div class="catalog">
            <?php foreach ($products as $product): ?>
                <?php if (condition($product, $currentCategory)): ?>
                    <div class="card">
                        <h2><?= $product['name'] ?></h2>
                        <?php if ($product['first_image'] === null): ?>
                            <div class="image-container">
                                <img src="/assets/images/img_placeholder.jpg" alt="Нет фото">
                            </div>
                        <?php else: ?>
                            <div class="image-container">
                                <img src="<?= $product['first_image'] ?>" alt="<?= $product['first_image'] ?>">
                            </div>
                        <?php endif; ?>
                        <a href="/more.php?id=<?= $product['id'] ?>">Подробнее</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<script src="/assets/js/admin.js"></script>
</body>
</html>