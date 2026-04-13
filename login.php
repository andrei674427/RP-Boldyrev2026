<?php
session_start();
include "includes/header.php";
include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Проверка email
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный email";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

      if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user'] = $user['username'];
    $_SESSION['role'] = $user['role']; // ДОБАВИЛИ РОЛЬ

    if ($user['role'] === 'admin') {
        header("Location: /admin/index.php");
    } else {
        header("Location: index.php");
    }

    exit;
}
    }
}
?>

<section class="page">
    <h1>Вход</h1>
    <?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Email:</label>
        <input type="text" name="username" required>

        <label>Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Войти</button>
    </form>
</section>

<?php include "includes/footer.php"; ?>