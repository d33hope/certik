<?php
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'];
    $last_name = $_POST['last_name'];

    if (empty($number) || empty($last_name)) {
        $response = "<div id='result'><p>Вы не ввели номер или фамилию</p></div>";
    } else {
        $query_c_check = mysqli_query($db, "SELECT * FROM `certificates` WHERE `number` = '$number' AND `last_name` = '$last_name'");
        if (mysqli_num_rows($query_c_check) > 0) {
            $row = mysqli_fetch_assoc($query_c_check); // Получаем данные строки из результата запроса
         
            $response = "<div id='result' class='check_result'>
            <div class='cert_img'><img src='/certificates/" . $row['path_p'] . "' alt='' '></div>
            <div class='qr_img'><img src='/qrcodes/" . $row['path_qr'] . "' alt='' '></div>
                            <table class='table_result'>
                                <tbody>
                                    <tr>
                                        <td><p>Сертификат</p></td>
                                        <td><p>№" . $row["number"] . "</p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Владелец</p></td>
                                        <td><p>" . $row["last_name"] ."&nbsp". $row["name"] . "</p></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><p>Площадка</p></td>
                                        <td><p>" . $row["academy_name"] . "</p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Курс</p></td>
                                        <td><p>" . $row["course_name"] . "</p></td>
                                    </tr>
                                </tbody>
                            </table>";
                           
            $response .= "</div>";
        
        } else {
            $response = "<div id='result'><p>Сертификат с указанным номером и фамилией не найден.
            Проверьте введённые данные.
            
            Возможно, вы совершили одну из распространённых ошибок:<br>
            - Фамилия введена неправильно — введите фамилию так же, как в сертификате.<br>
            - Вместе с фамилией введено имя — введите только фамилию.<br>
            - Номер введен неправильно</p></div>";
        }
    }
    
    echo $response;
}
?>
