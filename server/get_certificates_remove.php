<?php
require '../includes/config.php';
require '../includes/auth_check.php';

$perPage = 15; // Количество сертификатов на странице
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Номер текущей страницы

$offset = ($page - 1) * $perPage; // Смещение для выборки сертификатов из базы данных

$query_certificates = mysqli_query($db, "SELECT * FROM certificates WHERE id_users = '$user_id' AND status='remove' ORDER BY date_added DESC LIMIT $offset,$perPage");

while ($row_cert = mysqli_fetch_assoc($query_certificates)) {
    echo "<tr>";
    echo "<td>" . $row_cert['number'] . "</td>";
    echo "<td>" . $row_cert['name'] . "</td>";
    echo "<td>" . $row_cert['academy_name'] . "</td>";
    echo "<td>" . $row_cert['course_name'] . "</td>";
    echo "<td class='photo-column'>";
    echo "<button class='openBtn' onclick='togglePhoto(this)'>Показать фото</button>";
    echo "<div class='certificate-details hidden'>";
    echo "<img class='certificate-photo' src='/certificates/" . $row_cert['path_p'] . "' alt='Certificate Image'>";
    echo "</div>";
    echo "</td>";
    echo "<td>" . $row_cert['date_added'] . "</td>";
    echo "<td>";
    echo "<button class='delete-certificate-btn' onclick='restoreCertificate(" . $row_cert['id_cert'] . ")'>Восстановить</button>";
    echo "</td>";
    echo "</tr>";
}
?>
