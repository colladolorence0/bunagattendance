<?php
session_start();


if(isset($_SESSION['employee_id'])) {
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header('Location: employee_login.php');
    exit();
} else {
    header('Location: employee_login.php?error=login_first');
    exit();
}




// if (isset($_POST['logout']) && $_POST['logout'] == 1) {
//     // Unset all session variables
//     $_SESSION = array();

//     // Destroy the session
//     session_destroy();

//     // Redirect to login page
//     header('Location: employee_login.php');
//     exit();
// } else {
//     // Redirect to login page if logout action is not set
//     header('Location: employee_login.php');
//     exit();
// }
