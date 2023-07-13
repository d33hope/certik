<?
 require '../includes/config.php';
 require '../includes/auth_check.php';
 ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавленные сертификаты</title>
    <link rel="stylesheet" href="/css/style_test.css">
    <link rel="icon" href="/css/letter-c-svgrepo-com.svg" type="image/x-icon">
    <style>
        .hidden {
            display: none;
        }

        .load-more-container {
            text-align: center;
            margin-top: 10px;
        }
        
      
    </style>
    <script>
  var page = 1;
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
                btn.textContent = 'Скрыть';
            } else {
                details.classList.add('hidden');
                btn.textContent = 'Показать';
            }
        }

        function deleteCertificate(certificateId) {
            if (confirm("Вы действительно хотите удалить этот сертификат?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        // Обработать ответ от сервера, если необходимо
                        location.reload(); // Перезагрузить страницу после удаления сертификата
                    }
                };
                xhttp.open("GET", "remove_certificate.php?id=" + certificateId, true);
                xhttp.send();
            }
        }

        function searchCertificates() {
    var input = document.getElementById('search-input');
    var filter = input.value.toLowerCase();
    var table = document.getElementById('certificates-table');
    var rows = table.getElementsByTagName('tr');

    for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var found = false;

        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];
            if (cell.innerHTML.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        if (found) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}
function loadMoreCertificates() {
    page++;
    var url = "get_certificates.php?page=" + page;
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var table = document.getElementById('certificates-table');
            var loadMoreContainer = document.getElementById('load-more-container');
            var response = this.responseText;

            if (response.trim() !== '') {
                table.innerHTML += response;
                loadMoreContainer.innerHTML = "<button onclick='loadMoreCertificates()'>Загрузить ещё</button>";
            } else {
                loadMoreContainer.innerHTML = "Больше сертификатов нет";
            }
        }
    };

    xhttp.open("GET", url, true);
    xhttp.send();
}

    </script>
</head>
<body>
<!--<div class="search-container">
        <input type="text" id="search-input" placeholder="Поиск...">
        <button onclick="searchCertificates()">Найти</button>
    </div>-->
    <div class="top">
    <div class="logo"><a href="/modules/home.php"><p>CERTIK</p></a></div>
    <div class="links" style="left: 30%;"><a href="/modules/about.php"><p>О СЕРВИСЕ</p></a></div>
    <div class="links" style="left: 45%;"><p>ПАРТНЕРСТВО</p></div>
    <div class="links" style="left: 60%;"><p>ПОМОЩЬ</p></div>
    <div class="links" style="left: 85%;">
    <?php if(isset($loggedInUser)): ?>
        <a href="/server/cabinet.php" style="font-size:26px;"><?php echo $loggedInUser; ?></a>
    <?php else: ?>
        <a href="/server/cabinet.php" style="font-size:26px;">Кабинет</a>
    <?php endif; ?>
</div>
</div>
    <?php
   

    $login_user = $_SESSION['login_user'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE username = '$login_user'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    echo "<h1>Добавленные сертификаты</h1>";
    

    $query_certificates = mysqli_query($db, "SELECT * FROM certificates WHERE id_users = '$user_id' AND status='active' ORDER BY date_added DESC");
    $page++;

    echo "<table class='certificates-table' id='certificates-table' style='width:100%;'>";
  

    echo "<tr>";
  
      
    
    echo "<div class='search-container' id='search-container'>";
    echo"<input type='text' id='search-input' placeholder='Поиск...'>";
    echo" <button onclick='searchCertificates()'>Найти</button>";
    echo"</div>";
    echo "<th class='sortable' data-column='number' onclick='sortTable(this)'>Номер</th>";
    echo "<th class='sortable' data-column='name' onclick='sortTable(this)'>Фамилия</th>";
    echo "<th class='sortable' data-column='name' onclick='sortTable(this)'>Имя</th>";
    echo "<th class='sortable' data-column='academy_name' onclick='sortTable(this)'>Академия</th>";
    echo "<th class='sortable' data-column='course_name' onclick='sortTable(this)'>Название курса</th>";
    echo "<th>Фото</th>";
    echo "<th>QR</th>";
    echo "<th class='sortable' data-column='date_added' onclick='sortTable(this)'>Time</th>";
    echo "<th>Действия</th>";
    echo "</tr>";

    $perPage = 15; // Количество сертификатов на странице
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Номер текущей страницы
  
    $totalCertificates = mysqli_num_rows($query_certificates); // Общее число сертификатов
    
    $offset = ($page - 1) * $perPage; // Смещение для выборки сертификатов из базы данных
    
    $query_certificates = mysqli_query($db, "SELECT * FROM certificates WHERE status='active' ORDER BY date_added DESC LIMIT $offset, $perPage");

    while ($row_cert = mysqli_fetch_assoc($query_certificates)) {
        echo "<tr>";
        echo "<td>" . $row_cert['number'] . "</td>";
        echo "<td>" . $row_cert['last_name'] . "</td>";
        echo "<td>" . $row_cert['name'] . "</td>";
        echo "<td>" . $row_cert['academy_name'] . "</td>";
        echo "<td>" . $row_cert['course_name'] . "</td>";
        echo "<td class='photo-column'>";
        echo "<button class='openBtn' onclick='togglePhoto(this)'>Показать</button>";
        echo "<div class='certificate-details hidden'>";
        echo "<img class='certificate-photo' src='/certificates/" . $row_cert['path_p'] . "' alt='Certificate Image'>";
        echo "</div>";
        echo "</td>";
        echo "<td class='photo-column'>";
        echo "<button class='openBtn' onclick='togglePhoto(this)'>Показать</button>";
        echo "<div class='certificate-details hidden'>";
        echo "<img class='certificate-photo' src='/qrcodes/" . $row_cert['path_qr'] . "' alt='Certificate Image'>";
        echo "</div>";
        echo "</td>";
        echo "<td>" . $row_cert['date_added'] . "</td>";
        echo "<td>";
        echo "<button class='delete-certificate-btn' onclick='deleteCertificate(" . $row_cert['id_cert'] . ")'>Удалить</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<div id='load-more-container'>";
    echo "<button onclick='loadMoreCertificates()''>Загрузить ещё</button>"
    ?>
    <!--<div id="load-more-container">
    <button onclick="loadMoreCertificates()">Загрузить ещё</button>
  </div>-->

</body>
</html>