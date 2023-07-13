<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проверка сертификта</title>
    <link rel="stylesheet" href="/css/style_home.css">
    <link rel="icon" href="/css/letter-c-svgrepo-com.svg" type="image/x-icon">
    <style>
        .cert_img img {
            max-width:50%;
            max-height:50%;
        }
    </style>
</head>
<body>
<div class="top"> 
    <div class="logo"><a href="/modules/home.php"><p>CERTIK</p></a></div>
    <div class="links" style="left: 30%;"><a href="/modules/about.php"><p>О СЕРВИСЕ</p></a></div>
    <div class="links" style="left: 45%;"><a href="/modules/partnership.php"><p>ПАРТНЕРСТВО</p></a></div>
    <div class="links" style="left: 60%;"><a href="/modules/help.php"><p>ПОМОЩЬ</p></a></div>
    <div class="links" style="left: 85%;"><a href="/modules/auth.php" style="font-size:26px;">Войти</a></div>
</div>
<div class="cert_container">
    <h2>Проверка подлинности сертификата</h2>
    <form id="certForm" method="post" action="/server/cert_check.php">
        <div class="check">
            <input type="text" name="number" placeholder="Введите Номер сертификата">
            <input type="text" name="last_name" placeholder="Введите фамилию">
            <button type="button" name="sub" id="checkBtn">Проверить</button>
            <p>Здесь можно проверить сертификат на подлинность.<br>Пожалуйста, введите номер сертификата его владельца и нажмите кнопку проверить.</p>
        </div>
    </form>
    <div id="result"></div>
</div>
<div class="bot" style="margin-top:400px;">

</div>

<div class="bot_text">
<p style="position: absolute; max-width: 200px; right: 1%;">Система работает в тестовом режиме </p>
<p style="position: absolute;  max-width: 200px; left: 47%">certikcheck.ru © 2023</p>
<p style="position: absolute;  max-width: 200px; left: 1% text-align:left;" >Связаться с нами certik_help@certik.ru</p>
</div>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var checkBtn = document.getElementById("checkBtn");

        checkBtn.addEventListener("click", function() {
            var form = document.getElementById("certForm");
            var url = form.getAttribute("action");
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    console.log(response); // Выводим ответ в консоль для отладки

                    var result = document.getElementById("result");
                    if (result) {
                        result.innerHTML = response; // Обновляем содержимое элемента result с полученным ответом
                    }
                } else {
                    console.log("Ошибка при выполнении AJAX-запроса");
                }
            };

            xhr.onerror = function() {
                console.log("Ошибка при выполнении AJAX-запроса");
            };

            xhr.send(formData);
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Получаем параметры данных из URL-адреса
        const urlParams = new URLSearchParams(window.location.search);
        const certificateNumber = urlParams.get('number');
        const lastName = urlParams.get('last_name');

        // Заполняем поля формы автоматически
        document.getElementsByName('number')[0].value = certificateNumber;
        document.getElementsByName('last_name')[0].value = lastName;

        // Выполняем нажатие на кнопку "Проверить", если номер и фамилия присутствуют
        if (certificateNumber && lastName) {
            document.getElementById('checkBtn').click();
        }
    });
</script>

</body>
</html>
