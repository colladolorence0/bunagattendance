<?php
session_start();
include 'conn.php'; // Include your database connection file

if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Fetch attendance records for the logged-in employee
$employeeId = $_GET['id2']; // Assuming you are passing 'id2' as the employee ID
$sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid
        FROM attendance 
        LEFT JOIN employees ON employees.id = attendance.employee_id 
        WHERE employees.id = $employeeId
        ORDER BY attendance.date DESC, attendance.time_in DESC";
$query = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 100%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-x: auto; /* Add horizontal scroll if needed */
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
            padding: 10px; /* Adjust padding for smaller screens */
            text-align: left;
            white-space: nowrap; /* Prevent line breaks for long content */
        }

        table th {
            background-color: #f4f4f4;
        }

        /* Adjust the alignment of Time Out column */
        .time-out,
        .time-in {
            width: 120px; /* Set a fixed width for the Time In and Time Out columns */
        }

        /* Responsive Styles */
        @media only screen and (max-width: 768px) {
            table th,
            table td {
                padding: 8px; /* Adjust padding for smaller screens */
            }
        }

        @media only screen and (max-width: 576px) {
            table th,
            table td {
                padding: 6px; /* Further adjust padding for smaller screens */
                font-size: 12px; /* Reduce font size for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Attendance Records</h1>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th class="time-in">Time In</th>
                    <th class="time-out">Time Out</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fetch = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo date('F d, Y', strtotime($fetch['date'])) ?></td>
                        <td><?php echo $fetch['empid']; ?></td>
                        <td><?php echo $fetch['firstname'] . ' ' . $fetch['lastname']; ?></td>
                        <td><?php echo date('h:i A', strtotime($fetch['time_in'])) ?></td>
                        <td><?php echo date('h:i A', strtotime($fetch['time_out'])) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

