<?php
session_start();
include 'conn.php'; // Include your database connection file

if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Fetch employee record of the logged-in employee
$employee_id = $_SESSION['employee_id'];
$sql = "SELECT employees.*, position.description AS position_desc 
        FROM employees 
        LEFT JOIN position ON employees.position_id = position.id 
        WHERE employees.employee_id = '$employee_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
        }

        .back-btn {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Record</h1>
        <?php if ($result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Birthdate</th>
                        <th>Contact Info</th>
                        <th>Gender</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $row = $result->fetch_assoc(); ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['employee_id']; ?></td>
                        <td><?php echo $row['lastname'] . ', ' . $row['firstname']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['birthdate']; ?></td>
                        <td><?php echo $row['contact_info']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['position_desc']; ?></td> <!-- Display Position Description -->
                    </tr>
                </tbody>
            </table>
        <?php else : ?>
            <p>No employee record found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
