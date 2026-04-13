<?php
// Настройки подключения
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "real_patsany";

// Создаём соединение
$conn = new mysqli($host, $user, $pass, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Устанавливаем кодировку UTF-8
$conn->set_charset("utf8");
?>
