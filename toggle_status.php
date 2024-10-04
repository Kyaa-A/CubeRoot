<?php
include_once 'core/init.php';
include_once 'core/classes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $status = $_POST['status'];

    $db = Connect::connect();
    $stmt = $db->prepare("UPDATE users SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
