<?php

// Connect to the database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'apsystem';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Get the form data
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$created_on = date('Y-m-d H:i:s');

// Insert theuser into the database
$sql = "INSERT INTO `admin` (`username`, `password`, `firstname`, `lastname`, `created_on`) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'sssss', $username, $password, $firstname, $lastname, $created_on);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: register_success.php');
    } else {
        echo 'Error: ' . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo 'Error: ' . mysqli_error($conn);
}

mysqli_close($conn);

?>