<?php
session_start();
include "includes/db.php";
if(!isset($_SESSION['user'])) die("Войди");

$id=$_SESSION['user'];
$user=$conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>

<h1>Профиль</h1>

<p>Логин: <?= $user['login'] ?></p>

<form method="POST" action="update_profile.php">
<input name="avatar" placeholder="images/avatar.jpg">
<textarea name="bio" placeholder="О себе"></textarea>
<button>Сохранить</button>
</form>