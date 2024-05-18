<?php
$dsn = 'mysql:host=localhost;dbname=apsystem';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch associative arrays by default
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // Set character set to UTF-8
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    // Connection established successfully, $pdo is your PDO object
} catch(PDOException $e) {
    // Error occurred, handle it as needed
    echo 'Connection failed: ' . $e->getMessage();
    die(); // Terminate script execution
}
?>
