<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    // Trim input values to remove whitespaces
    $employee_id = trim($_POST['employee']);
    $bonus = trim($_POST['bonus']);
    $transportation = trim($_POST['transportation']);
    $overtime = trim($_POST['overtime']);

    // Check if the employee_id exists in the employees table
    $checkEmployee = "SELECT id FROM employees WHERE employee_id = '$employee_id'";
    $result = $conn->query($checkEmployee);

    if ($result->num_rows < 1) {
        // Employee does not exist, show error
        $_SESSION['error'] = "Error adding Other Earnings: Employee ID not found.";
        header("Location: earnings.php");
        exit();
    } else {
        $row = $result->fetch_assoc();
        $employee_id = $row['id'];
        $sql = "INSERT INTO other_earnings (employee_id, bonus, transportation_allowance, overtime) 
                VALUES ('$employee_id', '$bonus', '$transportation', '$overtime')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Other Earnings added successfully.";
            header("Location: earnings.php");
            exit();
        } else {
            $_SESSION['error'] = "Error adding Other Earnings: " . $conn->error;
            header("Location: earnings.php");
            exit();
        }
    }
} else {
    $_SESSION['error'] = 'Fill up add form first';
    header('Location: earnings.php');
    exit();
}
?>
