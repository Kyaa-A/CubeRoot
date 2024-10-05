<?php
include_once 'core/init.php';
include_once 'core/classes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $db = Connect::connect();
    $stmt = $db->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    if ($stmt->execute([$username, $email, $user_id])) {
        echo "User updated successfully";
    } else {
        echo "Error updating user";
    }
}
