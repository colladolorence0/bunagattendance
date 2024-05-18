<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $schedule = $_POST['schedule'];
    $photo_name = $_FILES['photo']['name'];
    $password = $_POST['password']; // Retrieve password as plain text

    // Move uploaded photo and QR code to their respective folders
    move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $photo_name);

    // Generate employee ID
    $letters = '';
    $numbers = '';
    foreach (range('A', 'Z') as $char) {
        $letters .= $char;
    }
    for ($i = 0; $i < 10; $i++) {
        $numbers .= $i;
    }
    $employee_id = substr(str_shuffle($letters), 0, 3) . substr(str_shuffle($numbers), 0, 9);

    // Prepare SQL statement with placeholders
    $sql = "INSERT INTO employees (employee_id, firstname, lastname, address, birthdate, contact_info, gender, position_id, schedule_id, photo, created_on, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to prepared statement
    $stmt->bind_param("sssssssssss", $employee_id, $firstname, $lastname, $address, $birthdate, $contact, $gender, $position, $schedule, $photo_name, $password);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Employee added successfully';
    } else {
        $_SESSION['error'] = $stmt->error;
    }

    $stmt->close(); // Close the prepared statement
} else {
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: employee.php');
?>
