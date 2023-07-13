<script src="/includes/jquery-3.7.0.min.js"></script>
<?php
require '../includes/config.php';
require '../includes/auth_check.php';

$login_user = $_SESSION['login_user'];
$user_id = $_SESSION['user_id'];

$column = $_GET['column'];
$direction = $_GET['direction'];

$order = "ORDER BY $column $direction";
$query_certificates = mysqli_query($db, "SELECT * FROM certificates WHERE id_users = '$user_id' $order");

$table_html = "<table class ='certificates-table' id='certificates-table'>";
$table_html .= "<tr><th class='sortable' data-column='number'>Номер</th><th class='sortable' data-column='name'>Имя</th><th class='sortable' data-column='academy_name'>Академия</th><th class='sortable' data-column='course_name'>Название курса</th><th>Действия</th></tr>";

while ($row_cert = mysqli_fetch_assoc($query_certificates)) {
    $table_html .= "<tr>";
    $table_html .= "<td>" . $row_cert['number'] . "</td>";
    $table_html .= "<td>" . $row_cert['name'] . "</td>";
    $table_html .= "<td>" . $row_cert['academy_name'] . "</td>";
    $table_html .= "<td>" . $row_cert['course_name'] . "</td>";
    $table_html .= "<td class='photo-column'>";
    $table_html .= "<button class='toggle-photo-btn'>Показать/Скрыть фото</button>";
    $table_html .= "<div class='certificate-details hidden'>";
    $table_html .= "<img class='certificate-photo' src='/img/" . $row_cert['path_p'] . "' alt='Certificate Image'>";
    $table_html .= "</div>";
    $table_html .= "</td>";
    $table_html .= "</tr>";
}

$table_html .= "</table>";

echo $table_html;
?>

