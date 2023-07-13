<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/style_test.css">
    <link rel="icon" href="/css/letter-c-svgrepo-com.svg" type="image/x-icon">
    <script>
        function validateForm() {
            var username = document.forms["authForm"]["username"].value;
            var password = document.forms["authForm"]["password"].value;

            if (username === "") {
                alert("Пожалуйста, введите почту или логин");
                return false;
            }

            if (password === "") {
                alert("Пожалуйста, введите пароль");
                return false;
            }

            return true;
        }
    </script>

<style>
    

    
    .form-input input.box {
        border: 1px solid #ccc;
    }

    .form-input input[type="submit"] {
        background-color: #2D8EE9;
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
    }

    .form-input input[type="submit"]:hover {
        background-color: #347b99;
    }
</style>
</head>

<body>
<div class="top">
    <div class="logo"><a href="/modules/home.php"><p>CERTIK</p></a></div>
    <div class="links" style="left: 30%;"><a href="/modules/about.php"><p>О СЕРВИСЕ</p></a></div>
    <div class="links" style="left: 45%;"><p>ПАРТНЕРСТВО</p></div>
    <div class="links" style="left: 60%;"><p>ПОМОЩЬ</p></div>
    <div class="links" style="left: 85%;"><a href="/modules/auth.php" style="font-size:26px;">Войти</a></div>
</div>
<div class="auth">
        <div align="center">
                <h3>Страница авторизации для образовательных площадок</h3>
                <form name="authForm" method="post" action="<?=$site_url;?>/server/auth.php" onsubmit="return validateForm();">
                    <div class="form-input">
                        <label>Почта или логин</label><br>
                        <input type="text" name="username" class="box" placeholder="Введите почту или логин"/><br>
                    </div>
                    <div class="form-input">
                        <label>Пароль</label><br>
                        <input type="password" name="password" class="box" placeholder="Введите пароль"/><br>
                    </div>
                    <div class="form-input">
                        <input type="submit" value="Войти" name="sub"/>
                    </div>
                </form>
          
    </div>
</div>
<div class="bot">
<div class="bot_text">
<p style="position: absolute; width: 200px; right: 1%; text-align:right;">Система работает в тестовом режиме </p>
<p style="position: absolute; width: 200px; left: 47%">certikcheck.ru © 2023</p>
<p style="position: absolute; width: 200px; left: 1%; text-align:left;" >Связаться с нами certik_help@certik.ru</p>
</div>
</body>
</html>

