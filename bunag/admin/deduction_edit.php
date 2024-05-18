<?php
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sss_contribution = $_POST['sss_contribution'];
    $philhealth_contribution = $_POST['philhealth_contribution'];
    $withholding_tax = $_POST['withholding_tax'];

    // Prepare and bind the UPDATE statement
    $stmt = $conn->prepare("UPDATE deductions SET sss_contribution = ?, philhealth_contribution = ?, withholding_tax = ? WHERE id = ?");
    $stmt->bind_param("dddi", $sss_contribution, $philhealth_contribution, $withholding_tax, $id); // 'd' indicates double/decimal type, 'i' indicates integer type
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Deduction updated successfully';
    } else {
        $_SESSION['error'] = 'Error updating deduction: ' . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Fill up edit form first';
}

header('location: deduction.php');
?>
