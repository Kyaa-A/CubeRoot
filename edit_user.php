<?php
include_once 'core/init.php';
include_once 'core/classes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $db = Connect::connect();
    $stmt = $db->prepare("UPDATE users SET name = :username, email = :email WHERE id = :id");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update user']);
    }
}
?>
