<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    $season = (int)$_POST['season'];
    $episode = (int)$_POST['episode'];

    // Получаем ID пользователя
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && !empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (user_id, season, episode, text) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $user['id'], $season, $episode, $comment);
        $stmt->execute();
    }
}

header("Location: videos.php");
exit;
?>