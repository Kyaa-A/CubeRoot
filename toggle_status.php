<?php
include 'core/init.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $id])) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
