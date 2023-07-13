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
        
#message {
    
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    padding: 20px;
    border: 1px solid #000000;
    font-size: 24px;
}

    </style>
  
</head>
<body>


<div class="top"> 
    <div class="logo"><a href="/modules/home.php"><p>CERTIK</p></a></div>
    <div class="links" style="left: 30%;"><a href="/modules/about.php"><p>О СЕРВИСЕ</p></a></div>
    <div class="links" style="left: 45%;"><a href="/modules/partnership.php"><p>ПАРТНЕРСТВО</p></a></div>
    <div class="links" style="left: 60%;"><a href="/modules/help.php"><p>ПОМОЩЬ</p></a></div>
    <div class="links" style="left: 85%;">
    <?php 
    require '../includes/config.php';
    require '../includes/auth_check.php';
    if(isset($loggedInUser)): ?>
        <a href="/server/cabinet.php" style="font-size:26px;"><?php echo $loggedInUser; ?></a>
    <?php else: ?>
        <a href="/server/cabinet.php" style="font-size:26px;">Кабинет</a>
    <?php endif; ?>
</div>
</div>

<?php
require '../includes/config.php';
require '../includes/auth_check.php';

// Функция для генерации случайного номера сертификата
function generateRandomNumber() {
    // Здесь реализуйте вашу логику генерации случайного номера
    return rand(1000, 9999);
}

// Включаем библиотеку для генерации QR-кода
require '../includes/phpqrcode/qrlib.php';

if (isset($_POST['sub'])) {
    $last_name = $_POST['last_name'];
    $name = $_POST['name'];
    $c_name = $_POST['c_name'];

    $user_id = $_SESSION['user_id']; // Предполагается, что идентификатор пользователя хранится в сессии
    
    $query_academy_id = mysqli_query($db, "SELECT id_academy FROM academies WHERE id_users = '$user_id'");
    $row_academy_id = mysqli_fetch_assoc($query_academy_id);
    $academy_id = $row_academy_id['id_academy'];

    $query_academy_name = mysqli_query($db, "SELECT acad_name FROM academies WHERE id_users = '$user_id'");
    $row_academy_name = mysqli_fetch_assoc($query_academy_name);
    $academy_name = $row_academy_name['acad_name'];
    

    // Проверяем, введен ли номер сертификата
    $showCertificateNumber = isset($_POST['show_certificate_number']) && $_POST['show_certificate_number'] == 'on';
    $certificateNumber = '';

    $allowedFileTypes = array('png', 'jpg', 'jpeg');
    $maxFileSize = 10 * 1024 * 1024; // 10MB
    $file = $_FILES['photo'];
    $name_p = $file['name'];

    if ($showCertificateNumber) {
        // Если номер введен, используем его
        $certificateNumber = isset($_POST['certificate_number']) ? $_POST['certificate_number'] : '';
    } else {
        // Если номер не введен, генерируем случайный номер
        $certificateNumber = generateRandomNumber(); // Здесь необходимо использовать вашу функцию для генерации номера
    }

    if (empty($name) || empty($c_name)) {
        exit("<p style='position: absolute;width: 400px;height: 50px;left: 40%;top: 40%; color: #000000;font-size: 24px'>Вы ввели не всю информацию <p>");
        echo ("<a href='page.php' style='position: absolute;width: 400px;height: 50px;left: 40%;top: 46%; color: #000000;font-size: 24px'>ссылка</a>");
    }

    if (empty($file['tmp_name'])) {
        exit("<p style='position: absolute;width: 400px;height: 50px;left: 30%;top: 30%; color: #000000;font-size: 24px'>Вы не загрузили сертификат<p>");
    }

$maxFileSize = 10 * 1024 * 1024; // 10MB
$allowedFileTypes = array('png', 'jpg', 'jpeg');

$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($fileExtension, $allowedFileTypes)) {
    exit("<p style='position: absolute;width: 400px;height: 50px;left: 30%;top: 30%; color: #000000;font-size: 24px'>Недопустимый тип файла<p>");
}

if ($file['size'] > $maxFileSize) {
    exit("Превышен максимальный размер файла");
}

    // Генерируем QR-код
    $qrCodeUrl = "https://cert.ru/modules/home.php?number=$certificateNumber&last_name=$last_name";
    $qrCodeText = $qrCodeUrl;
    $path_qr = 'qr_'.$certificateNumber ."_".$last_name.'.png';
    $qrCodePath = __DIR__ . '/../qrcodes/'.$path_qr;
    QRcode::png($qrCodeText, $qrCodePath);

    $name_ph = 'cr_'.$certificateNumber ."_".$last_name.'.png';
    $pathFile = __DIR__ .'/../certificates/'.$name_ph;
    if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
        echo("Сертификат не добавлен");
    } 

    $query_c_add = mysqli_query($db, "INSERT INTO certificates (number, name, last_name, academy_name, course_name, path_p, path_qr, id_users, id_acad, date_added) 
    VALUES ('$certificateNumber', '$name','$last_name', '$academy_name', '$c_name', '$name_ph','$path_qr', '$user_id', '$academy_id', NOW())");

if ($query_c_add) {

    echo "<div id='message' style='text-align: center;'><p>Вы успешно загрузили сертификат</p>";
    echo "<p>Номер сертификата: " . $certificateNumber . "</p>";

    
    // Отображение QR-кода и формы
    echo "<a href='$qrCodeUrl'>";
    echo "<img src=/qrcodes/$path_qr alt='QR Code'><br>";
    echo "</a>";
    echo "<a href='/server/cabinet.php' style='color:black;'>Перейти в личный кабинет</a><br>";
    echo "<a href='/modules/cert_add.php' style='color:black;'>Добавить ещё сертификат</a>";
    echo "</div>";
} else {
    echo "<div id='message' style='text-align: center;'><p>Ошибка при выполнении запроса: " . mysqli_error($db) . "</p></div>";
}
}
?>

<div class="bot" style="position: absolute;">
<div class="bot_text">
<p style="position: absolute; width: 200px; right: 1%; text-align:right;">Система работает в тестовом режиме </p>
<p style="position: absolute; width: 200px; left: 47%">certikcheck.ru © 2023</p>
<p style="position: absolute; width: 200px; left: 1%; text-align:left;" >Связаться с нами certik_help@certik.ru</p>
</div>
</body>
</html>
