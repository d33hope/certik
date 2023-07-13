<?php
require 'config.php';
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['login_user'])) {
    header("Location: auth.php");
    exit();
}

// Подключение к базе данных

// Получение идентификатора пользователя из базы данных
$username = mysqli_real_escape_string($db, $_SESSION['login_user']); // Экранирование символов для предотвращения SQL-инъекций
$query = mysqli_prepare($db, "SELECT id_user FROM users WHERE username = ?"); // Подготовленный запрос
mysqli_stmt_bind_param($query, "s", $username); // Привязка параметров
mysqli_stmt_execute($query); // Выполнение запроса
$user = mysqli_stmt_get_result($query); // Получение результата запроса
$user = mysqli_fetch_assoc($user);
$user_id = $user['id_user'];

// Сохранение идентификатора пользователя в сессию
$_SESSION['user_id'] = $user_id;

// Проверка активной сессии
if(isset($_SESSION['login_user'])) {
    $loggedInUser = $_SESSION['login_user'];
}

// Дополнительная проверка целостности и подлинности сессии (необязательно)
if ($_SESSION['user_id'] != $user_id) {
    header("Location: auth.php");
    exit();
}
?>
