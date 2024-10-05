<?php
// Include your database connection
include('core/classes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param('ssi', $username, $email, $userId);

    if ($stmt->execute()) {
        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return error response
        echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
    }
    $stmt->close();
}
$conn->close();
?>
