<?php
require_once 'conn.php';
require_once 'phpqrcode/qrlib.php';

if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Fetch employee data based on ID if needed
    // Modify this part according to your database structure and logic

    // For example, assuming you have employee data and want to generate QR based on employee ID
    $qrtext = '' . $employee_id; // Customize QR text as needed
    $path = 'images/';
    $qrcode = $path . time() . ".png";
    $qrcode2 = time(). ".png";

    QRcode::png($qrtext, $qrcode, 'H', 4, 4);

    // Return JSON response if needed
    echo json_encode(array('success' => true, 'qrimage' => $qrcode));
    mysqli_query($connection, "UPDATE `employees` set `qrtext` = '$qrcode2' WHERE `employee_id` = '$employee_id'") or die(mysqli_error());
} else {
    // Handle invalid request
    echo json_encode(array('success' => false, 'message' => 'Invalid request'));
}
?>
