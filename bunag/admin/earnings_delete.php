<?php
include 'includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM other_earnings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Other Earnings deleted successfully';
        echo 'success: Other Earnings deleted successfully'; // Send success response back to AJAX request
    } else {
        $_SESSION['error'] = 'Error deleting Other Earnings: ' . $stmt->error;
        echo 'error: Failed to delete Other Earnings: ' . $stmt->error; // Send error response back to AJAX request
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Invalid request. Please provide an ID.';
    echo 'error: No ID provided'; // Send error response back to AJAX request
}
?>
