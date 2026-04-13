<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (strlen($name) < 2) {
        $error = "Имя слишком короткое";
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ? WHERE username = ?");
        $stmt->bind_param("ss", $name, $_SESSION['user']);
        $stmt->execute();

        header("Location: index.php");
        exit;
    }
}
?>

<h2>Введите имя пользователя</h2>

<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <input type="text" name="name" placeholder="Ваше имя" required>
    <button type="submit">Сохранить</button>
</form>