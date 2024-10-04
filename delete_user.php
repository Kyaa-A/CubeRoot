<?php
include 'core/init.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: admin_panel.php');
        exit();
    } else {
        echo "Error deleting user.";
    }
}
?>
