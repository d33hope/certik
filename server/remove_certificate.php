<?php
require '../includes/config.php';
require '../includes/auth_check.php';

if (isset($_GET['id'])) {
    $certificateId = $_GET['id'];

    $sql = "UPDATE certificates SET status = 'remove' WHERE id_cert = $certificateId";
    mysqli_query($db, $sql);
}
?>
