<?php
require '../includes/config.php';
require '../includes/auth_check.php';
session_start();

$showCertificateNumber = isset($_POST['show_certificate_number']) && $_POST['show_certificate_number'] == 'on';
$certificateNumber = isset($_POST['certificate_number']) ? $_POST['certificate_number'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление сертификата</title>
    <link rel="stylesheet" href="/css/style_test.css">
    <link rel="icon" href="/css/letter-c-svgrepo-com.svg" type="image/x-icon">
    <style>
           .add input[type="file"] {
        display: none;
    }
    .container{
        margin-left:5px;
        margin-top:0px;
        width:400px;
        display:flex;
        
    }

    .add #uploadedPhoto {
            position: relative;
            margin-top: 20px;
            max-width: 200px;
            height: auto;
        }
  
    </style>
  
</head>
<body>
<!--<div class="top"><p style="position: absolute;width: 288px;height: 78px;left: 160px;top: 0px;">Добавление сертификата</p><img src="/css/top.png"> </div>
    <div class="right"><p style="position: absolute;width: 420px;height: 451px;left: 0px;top: 315px;">Certik-централизованная система по проверки сертификатов онлайн образования</p><img src="/css/left.png"> </div>
    <div class="left"><p style="position: absolute;width: 413px;height: 457px;left: 0px;top: 353px;">Сервис находится на ранней стадии разработки</p><img src="/css/right.png"> </div>
    <div class="bot"><p style="position: absolute;width: 490px;height: 54px;left: 479px;top: 0px;font-size:18px;">2022 © Certik</p><img src="/css/bot.png"> </div>-->

<div class="top">
    <div class="logo"><a href="/modules/home.php"><p>CERTIK</p></a></div>
    <div class="links" style="left: 30%;"><a href="/modules/about.php"><p>О СЕРВИСЕ</p></a></div>
    <div class="links" style="left: 45%;"><p>ПАРТНЕРСТВО</p></div>
    <div class="links" style="left: 60%;"><p>ПОМОЩЬ</p></div>
    <div class="links" style="left: 85%;">
    <?php  $login_user = $_SESSION['login_user'];
    $user_id = $_SESSION['user_id'];
    if(isset($loggedInUser)): ?>
        <a href="/server/cabinet.php" style="font-size:26px;"><?php echo $loggedInUser; ?></a>
    <?php else: ?>
        <a href="/server/cabinet.php" style="font-size:26px;">Кабинет</a>
    <?php endif; ?>
</div>
</div>

<div class="add" align="center">
    <h2>Добавление сертификата</h2>
    <form method="post" action="<?=$site_url;?>/server/cert_add.php" enctype="multipart/form-data">
        <input type="text" name="last_name" placeholder="Введите фамилию" required><br><br>
        <input type="text" name="name" placeholder="Введите имя"><br><br>
        
        <input type="text" name="c_name" placeholder="Введите название курса"><br><br>
        
        <input type="checkbox" name="show_certificate_number" id="show_certificate_number" <?php echo $showCertificateNumber ? 'checked' : ''; ?>>
        <label for="show_certificate_number">Ввести номер сертификата</label><br><br>
        
        <input type="text" name="certificate_number" id="certificate_number" placeholder="Введите номер сертификата" <?php echo $showCertificateNumber ? '' : 'style="display: none;"'; ?> value="<?php echo $certificateNumber; ?>"><br><br>
        <div class="container">
    <div class="image">
    <label for="photo" >Добавить фото</label>
    <input type="file" id="photo" name="photo" accept="image/*" reqaired>
    <span id="file-name"></span>
    </div>
        <input type="submit" name="sub" value="Добавить сертификат" style="color:white;">
        </div>
    </form>
    <img id="uploadedPhoto" class="uploaded-photo" src="" alt="">
</div>

<div class="bot">
<div class="bot_text">
<p style="position: absolute; width: 200px; right: 1%; text-align:right;">Система работает в тестовом режиме </p>
<p style="position: absolute; width: 200px; left: 47%">certikcheck.ru © 2023</p>
<p style="position: absolute; width: 200px; left: 1%; text-align:left;" >Связаться с нами certik_help@certik.ru</p>
</div>
<script>
    var showCertificateNumberCheckbox = document.getElementById('show_certificate_number');
    var certificateNumberInput = document.getElementById('certificate_number');

    showCertificateNumberCheckbox.addEventListener('change', function() {
        if (showCertificateNumberCheckbox.checked) {
            certificateNumberInput.style.display = '';
        } else {
            certificateNumberInput.style.display = 'none';
        }
    });
</script>
<script>
        var photoInput = document.getElementById('photo');
        var uploadedPhoto = document.getElementById('uploadedPhoto');

        photoInput.addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                uploadedPhoto.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    </script>

<script>
    function validateForm(event) {
        var lastNameInput = document.querySelector('input[name="last_name"]');
        var nameInput = document.querySelector('input[name="name"]');
        var cNameInput = document.querySelector('input[name="c_name"]');
        var photoInput = document.getElementById('photo');
     
        

        if (lastNameInput.value.trim() === '') {
            alert('Пожалуйста, введите фамилию.');
            event.preventDefault();
            return;
        }

        if (nameInput.value.trim() === '') {
            alert('Пожалуйста, введите имя.');
            event.preventDefault();
            return;
        }

        if (cNameInput.value.trim() === '') {
            alert('Пожалуйста, введите название курса.');
            event.preventDefault();
            return;
        }
        if (photoInput.value.trim() === '') {
            alert('Пожалуйста, добавьте фото.');
            event.preventDefault();
            return;
        }
    }

    var form = document.querySelector('form');
    form.addEventListener('submit', validateForm);
</script>
</body>
</html>