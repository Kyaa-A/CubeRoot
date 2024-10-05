<?php
require_once 'core/classes/connection.php'; // Adjust if necessary

header('Content-Type: application/json'); // Ensure JSON response

$conn = Connect::connect(); // Establish database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure variables are set
    $id = $_POST['id'] ?? null;
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;

    // Basic validation
    if ($id && $username && $email) {
        // Prepare your update query
        $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn = null; // Close the connection
?>
