<?php
require '../includes/config.php';
session_start();
if (isset($_POST['sub'])) {
   // username and password sent from form 
   $myusername = mysqli_real_escape_string($db, $_POST['username']);
$mypassword = mysqli_real_escape_string($db, $_POST['password']); 

// Проверка, является ли $myusername логином или электронной почтой
if (filter_var($myusername, FILTER_VALIDATE_EMAIL)) {
    $condition = "email = '$myusername'";
} else {
    $condition = "username = '$myusername'";
}

$sql = "SELECT id_user FROM users WHERE $condition AND password = '$mypassword'";
$result = mysqli_query($db, $sql);
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   $active = $row['active'];
      
   $count = mysqli_num_rows($result);
      
   // If result matched $myusername and $mypassword, table row must be 1 row
   if($count == 1) {
      $_SESSION['login_user'] = $myusername; // Установка значения сессии
      header("location: cabinet.php"); // Перенаправление на личный кабинет
   } else {
         #$error = "Your Login Name or Password is invalid";
         echo "<input type='button' value='Вы ввели неверный логи или пароль,попробовать ещё раз?' onclick='history.go(-1)'>";
      }
   }
?>