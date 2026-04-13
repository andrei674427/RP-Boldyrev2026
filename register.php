<?php
session_start();
include "includes/header.php";
include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password_raw = trim($_POST['password']);

    // Проверка email
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный email";
    }
    // Проверка пароля
    elseif (strlen($password_raw) < 6) {
        $error = "Пароль должен быть не менее 6 символов";
    }
    else {
        $password = password_hash($password_raw, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->fetch_assoc()) {
            $error = "Пользователь уже существует";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();

            $_SESSION['user'] = $username;
            header("Location: set_name.php");
            exit;
        }
    }
}
?>

<section class="page">
    <h1>Регистрация</h1>
    <?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Email:</label>
        <input type="text" name="username" required>

        <label>Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Зарегистрироваться</button>
    </form>
</section>

<?php include "includes/footer.php"; ?>