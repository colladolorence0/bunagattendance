<?php
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM deductions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Deduction deleted successfully';
        echo 'success'; // Send success response back to AJAX request
    } else {
        $_SESSION['error'] = 'Error deleting deduction: ' . $stmt->error;
        echo 'error'; // Send error response back to AJAX request
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Invalid request. Please select an item to delete.';
    echo 'error'; // Send error response back to AJAX request
}
?>
