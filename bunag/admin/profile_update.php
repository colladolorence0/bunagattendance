<?php
include 'includes/session.php';

if (isset($_GET['return'])) {
    $return = $_GET['return'];
} else {
    $return = 'home.php';
}

if (isset($_POST['save'])) {
    $curr_password = $_POST['curr_password'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $photo = $_FILES['photo']['name'];

    if (password_verify($curr_password, $user['password'])) {
        if (!empty($photo)) {
            move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $photo);
            $filename = $photo;
        } else {
            $filename = $user['photo'];
        }

        if ($password == $user['password']) {
            $password = $user['password'];
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        // Use prepared statement to update admin profile
        $sql = "UPDATE admin SET username = ?, password = ?, firstname = ?, lastname = ?, photo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $password, $firstname, $lastname, $filename, $user['id']);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Admin profile updated successfully';
        } else {
            $_SESSION['error'] = $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = 'Incorrect password';
    }
} else {
    $_SESSION['error'] = 'Fill up required details first';
}

header('location:' . $return);
?>