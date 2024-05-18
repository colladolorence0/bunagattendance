<?php
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $bonus = $_POST['bonus'];
    $overtime = $_POST['overtime'];
    $transportation = $_POST['transportation'];

    // Prepare and bind the UPDATE statement
    $stmt = $conn->prepare("UPDATE other_earnings SET bonus = ?, overtime = ?, transportation_allowance = ? WHERE id = ?");
    $stmt->bind_param("dddi", $bonus, $overtime, $transportation, $id); // 'd' indicates double/decimal type, 'i' indicates integer type
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Earnings updated successfully';
    } else {
        $_SESSION['error'] = 'Error updating earnings: ' . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Fill up edit form first';
}

header('location: earnings.php');
?>
 