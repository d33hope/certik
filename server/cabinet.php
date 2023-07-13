<?require '../includes/config.php';
    require '../includes/auth_check.php';
    session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="/css/style_test.css">
    <link rel="icon" href="/css/letter-c-svgrepo-com.svg" type="image/x-icon">
   
    
    <script>
        function sortTable(column) {
            var table = document.getElementById('certificates-table');
            var rows = table.rows;
            var switching = true;
            var shouldSwitch, i;
            var direction = 'asc';

            if (column.dataset.direction === 'asc') {
                column.dataset.direction = 'desc';
                direction = 'desc';
            } else {
                column.dataset.direction = 'asc';
            }

            while (switching) {
                switching = false;
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    var x = rows[i].getElementsByTagName('TD')[column.cellIndex];
                    var y = rows[i + 1].getElementsByTagName('TD')[column.cellIndex];

                    if (direction === 'asc') {
                        if (isNaN(x.innerHTML) || isNaN(y.innerHTML)) {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        } else {
                            if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    } else if (direction === 'desc') {
                        if (isNaN(x.innerHTML) || isNaN(y.innerHTML)) {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        } else {
                            if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

        function togglePhoto(btn) {
            var parent = btn.parentNode;
            var details = parent.querySelector('.certificate-details');
            var isHidden = details.classList.contains('hidden');

            if (isHidden) {
                details.classList.remove('hidden');
                btn.textContent = 'Скрыть фото';
            } else {
                details.classList.add('hidden');
                btn.textContent = 'Показать фото';
            }
        }
    </script>
 <style>
    /* Ваши стили */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      display: flex;
      flex-wrap: wrap;
      margin-top:3%;
    }

    .blocka {
      flex: 1 1 300px;
      margin: 10px;
     
      padding: 20px;
    }

    .blocka h2 {
      margin-top: 0;
    }

    ul{
        left:1000px;
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
    <?php if(isset($loggedInUser)): ?>
        <a href="/server/cabinet.php" style="font-size:26px;"><?php echo $loggedInUser; ?></a>
    <?php else: ?>
        <a href="/server/cabinet.php" style="font-size:26px;">Кабинет</a>
    <?php endif; ?>
</div>
</div>
<h2 align="center" style="margin-top:10%;">Личный кабинет</h2>
  <div class="container">
    <div class="blocka" style="margin-left:13%;">
<?php
    $login_user = $_SESSION['login_user'];
    $user_id = $_SESSION['user_id'];

    // Получение информации о пользователе из базы данных
    $sql_u = "SELECT * FROM users WHERE id_user= '$user_id'";
    $result_u = mysqli_query($db, $sql_u);
    $row_u = mysqli_fetch_assoc($result_u);

    $sql_a = "SELECT * FROM academies WHERE id_users= '$user_id'";
    $result_a = mysqli_query($db, $sql_a);
    $row_a = mysqli_fetch_assoc($result_a);

      echo "<h2 style='width:300px;font-size:20px;'>Информация о пользователе</h2>";
      echo "<ul type='circle'>";
      echo "<li>Логин:". $row_u['username'] ."</li>";
      echo "<li>Контактная почта:". $row_u['email'] ."</li>";
      echo "<li>Полное наименование площадки:". $row_a['full_acad_name'] ."</li>";
      echo "<li>ИНН:". $row_a['inn'] ."</li>";
   
    ?>
</ul>
    </div>

    <div class="blocka">
 
  <div class="cabinet_container_cert_actions">
    <a class="button-like-link" href="all_certificates.php" style="margin-left:1%;">Все добавленные сертификаты</a>
    <a class="button-like-link" href="all_certificates_deleted.php" style="margin-left:1%;">Все удаленные сертификаты</a><br>
    <a class="button-like-link" href="/modules/cert_add.php" style="margin-left:1%;">Добавление сертификата</a>
  </div>
</div>

    <div class="blocka" align="center" style=" background: none; max-width:auto;">
    
<?
    $login_user = $_SESSION['login_user'];
    $user_id = $_SESSION['user_id'];

    // Получение информации о пользователе из базы данных
    $sql = "SELECT * FROM users WHERE username = '$login_user'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    // Получение добавленных сертификатов пользователя
    $weekAgo = date('Y-m-d', strtotime('-1 week')); // Неделя назад
    $query_cert = mysqli_query($db, "SELECT * FROM certificates WHERE id_users = '$user_id' AND date_added >= '$weekAgo' ORDER BY date_added DESC LIMIT 10");

    $query_dates = mysqli_query($db, "SELECT DISTINCT DATE(date_added) AS cert_date FROM certificates WHERE id_users = '$user_id' ORDER BY cert_date DESC");

    // Отображение информации о пользователе
   
    echo "<h4>Последние сертификаты, добавленные за неделю:</h4>";
    /*echo "Логин: " . $row['username'] . "<br>";
    echo "Пароль: " . $row['password'] . "<br>";
   // Displaying the table inside the container*/
   echo "<div class='certificates-table'>";
   echo "<table id='certificates-table'>";
   // Table header
   echo "<tr>";
   echo "<th class='sortable' data-column='number' onclick='sortTable(this)'>Номер</th>";
   echo "<th class='sortable' data-column='name' onclick='sortTable(this)'>Фамилия</th>";
   echo "<th class='sortable' data-column='name' onclick='sortTable(this)'>Имя</th>";
   echo "<th class='sortable' data-column='academy_name' onclick='sortTable(this)'>Академия</th>";
   echo "<th class='sortable' data-column='course_name' onclick='sortTable(this)'>Название курса</th>";
   echo "<th>Фото</th>";
   echo "<th class='sortable' data-column='date_added' onclick='sortTable(this)'>Дата добавления</th>";
   echo "</tr>";

   // Displaying added certificates

    // Отображение добавленных сертификатов
    if (mysqli_num_rows($query_cert) > 0) {
     
        while ($row_cert = mysqli_fetch_assoc($query_cert)) {
            echo "<tr>";

            echo "<td>" . $row_cert['number'] . "</td>";
            echo "<td>" . $row_cert['last_name'] . "</td>";
            echo "<td>" . $row_cert['name'] . "</td>";
            echo "<td>" . $row_cert['academy_name'] . "</td>";
            echo "<td>" . $row_cert['course_name'] . "</td>";
            echo "<td>";
            echo "<button onclick='togglePhoto(this)' class='openBtn'>Показать фото</button>";
            echo "<div class='certificate-details hidden'>";
            echo "<img class='certificate-photo' src='/certificates/" . $row_cert['path_p'] . "' alt='Certificate Image'>";
            echo "</div>";
            echo "</td>";
            echo "<td>" . $row_cert['date_added'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td colspan='6'>У вас нет добавленных сертификатов.</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>"; // Close the .certificates-table div
    
    ?>

     
    </div>
  </div>

  <div class="bot" style="margin-top:150px;">
<div class="bot_text">
<p style="position: absolute; width: 200px; right: 1%; text-align:right;">Система работает в тестовом режиме </p>
<p style="position: absolute; width: 200px; left: 47%">certikcheck.ru © 2023</p>
<p style="position: absolute; width: 200px; left: 1%; text-align:left;" >Связаться с нами certik_help@certik.ru</p>
</div>
</body>
</html>
