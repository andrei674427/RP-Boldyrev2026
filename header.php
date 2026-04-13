<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "includes/db.php";

$userName = null;

if (isset($_SESSION['user'])) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && !empty($user['name'])) {
        $userName = $user['name'];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Фан-сайт по телесериалу "Реальные пацаны"</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="/index.php">
            <img src="/images/logotip.jpg" alt="Логотип">
        </a>
    </div>

    <nav>
        <a href="/index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Главная</a>
        <a href="/videos.php" class="<?= basename($_SERVER['PHP_SELF']) === 'videos.php' ? 'active' : '' ?>">Серии</a>
        <a href="/gallery.php" class="<?= basename($_SERVER['PHP_SELF']) === 'gallery.php' ? 'active' : '' ?>">Галерея</a>
        <a href="/trailers.php" class="<?= basename($_SERVER['PHP_SELF']) === 'trailers.php' ? 'active' : '' ?>">Трейлеры</a>
        <a href="/actors.php" class="<?= basename($_SERVER['PHP_SELF']) === 'actors.php' ? 'active' : '' ?>">Актёры</a>
        <a href="/about.php" class="<?= basename($_SERVER['PHP_SELF']) === 'about.php' ? 'active' : '' ?>">О сериале</a>

        <?php if(isset($_SESSION['user'])): ?>
            
            <?php if ($userName): ?>
                <span>Привет, <?= htmlspecialchars($userName) ?></span>
            <?php endif; ?>

            <a href="/logout.php">Выход</a>

        <?php else: ?>
            <a href="/login.php">Вход</a>
            <a href="/register.php">Регистрация</a>
        <?php endif; ?>
    </nav>
</header>
