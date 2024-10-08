<?php
/** @var PDO $pdo */
$pdo = require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$product = $pdo->query("SELECT *
FROM `products` JOIN `images`
ON `products`.`id` = `images`.`products_id`
WHERE `products`.id = " . $_GET['id'] ?? ''
)->fetch(PDO::FETCH_ASSOC);

$images = $pdo->query("SELECT image FROM `images` WHERE `products_id` = " . $_GET['id'] ?? '')->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/assets/icons/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/more.css">
    <title><?= $product['name'] ?></title>
</head>
<body>

<?php if ($product['published']): ?>
    <div class="container">
        <h1><?= $product['name'] ?></h1>

        <div class="image-wrapper">
            <?php foreach ($images as $image): ?>
                <?php if ($image['image'] === null): ?>
                    <div class="image-container">
                        <img src="/assets/images/img_placeholder.jpg" alt="Нет фото">
                    </div>
                <?php else: ?>
                    <div class="image-container">
                        <img src="<?= $image['image'] ?>" alt="<?= $image['image'] ?>">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <h2>Описание</h2>
        <p><?= $product['description'] ?></p>
    </div>
<?php else: ?>
    <img src="/assets/images/404.png" alt="404" width="100%">
<?php endif; ?>

</body>
</html>