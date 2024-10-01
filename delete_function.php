<?php
session_start();
require 'core/classes/connection.php'; // Update to your actual path

if (isset($_POST['delete'])) {
    $user_id = $_POST['id'];

    // Create a new connection
    $conn = Connect::connect();

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM users WHERE stud_id = :id");
    $stmt->bindParam(':id', $user_id);

    if ($stmt->execute()) {
        // Redirect back to admin panel or show success message
        header('Location: admin_panel.php?status=success');
    } else {
        // Handle error if needed
        header('Location: admin_panel.php?status=error');
    }
} else {
    // Redirect back to admin panel if no delete request was made
    header('Location: admin_panel.php');
}
?>
