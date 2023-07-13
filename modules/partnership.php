<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О сервисе</title>
    <link rel="stylesheet" href="/css/style_home.css">
    <link rel="icon" href="/css/letter-c-svgrepo-com.svg" type="image/x-icon">

    <style>
     

        h1{
            font-size:36px;
        }

        .obratnuj-zvonok{
    margin-top:10%;
    margin-left:42%;
	width: 100%;
	max-width: 350px;
}
.form-zvonok{
	width: 100%;
	display: flex;
	flex-direction: column;
	padding: 0 20px;
	box-sizing: border-box;
}
.form-zvonok div{
	padding: 15px 0;
}
.bot-send-mail{
	box-sizing: border-box;
	width: 100%;
}
.form-zvonok label,.form-zvonok input{
	display: block;
	width: 100%;
	box-sizing: border-box;
}
.form-zvonok label{
	margin-bottom: 5px;
	font-weight: bold;
}
.form-zvonok input{
	padding: 10px 15px;
	margin-top: 10px;
}
.form-zvonok label span{
	color: red;
}
.form-zvonok .bot-send-mail{
	padding: 15px;
	margin-top: 10px;
	background: none;
	border: none;
	text-transform: uppercase;
	color: #fff;
	font-weight: bold;
	background-color: #2D8EE9;
	cursor: pointer;
	border: 3px #2D8EE9 solid;
	border-radius: 5px;
}
.form-zvonok .bot-send-mail:hover{
	color: #2D8EE9;
	background-color: #fff;
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

<form class="obratnuj-zvonok" autocomplete="off" action='email.php' method='post'>
<div class="form-zvonok"> 
<h2 style="width:300px; font-size:18px; text-align:center;">По вопросам сотруднечества заполните форму</h2>
  <div>
    <label>Имя <span>*</span></label>
    <input type='text' name='username' required></div>
    <div>
    <label>Почта <span>*</span></label>
    <input type='text' name='usernumber' required></div>
  <div>
    <label>Номер телефона<span></span></label>
    <input type='text' name='usernumber'></div>
    <div>
    <label>Тема</label>
    <input type='text' name='theme'>
  </div>
  <div>
    <label>Сообщение <span>*</span></label>
    <input type='text' name='question' required>
  </div>
  <input class="bot-send-mail" type='submit' value='Отправить'>
  <p style="font-size:16px;"><span style="color:red;">*</span> Обязательно к заполнению</p>
</div>
</form>

<div class="bot" style="margin-top:150px;">
<div class="bot_text">
<p style="position: absolute; width: 200px; right: 1%; text-align:right;">Система работает в тестовом режиме </p>
<p style="position: absolute; width: 200px; left: 47%">certikcheck.ru © 2023</p>
<p style="position: absolute; width: 200px; left: 1% text-align:left;" >Связаться с нами certik_help@certik.ru</p>
</div>
</body>
</html>
