<?php
session_start();
include 'conn.php'; // Include your database connection file

if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Fetch the logged-in employee's ID
$employee_id = $_SESSION['employee_id'];

$to = date('Y-m-d');
$from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

if (isset($_GET['range'])) {
    $range = $_GET['range'];
    $ex = explode(' - ', $range);
    $from = date('Y-m-d', strtotime($ex[0]));
    $to = date('Y-m-d', strtotime($ex[1]));
}

$sqlPayroll = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' AND employees.employee_id = '$employee_id' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC;";

$resultPayroll = $conn->query($sqlPayroll);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payroll</title>
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

        .alert {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payroll Information</h1>
        <table id="example1" class="table table-bordered">
            <thead>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Gross</th>
                <th>SSS Contribution</th>
                <th>PhilHealth Deduction</th>
                <th>Withholding Tax</th>
                <th>Cash Advance</th>
                <th>Net Pay</th>
            </thead>
            <tbody>
                <?php
                $total = 0;
                while ($row = $resultPayroll->fetch_assoc()) {
                    $empid = $row['empid'];

                    // Calculate SSS Contribution
                    $sss_contribution = ($row['rate'] * $row['total_hr']) * 0.045;

                    // Calculate PhilHealth Deduction based on the employee's actual salary
                    $philhealth_rate = 0.05; // Default rate for all salaries
                    $salary = $row['rate'] * $row['total_hr']; // Calculate the employee's salary
                    $philhealth_contribution = $salary * $philhealth_rate / 2; // Divide by 2 for employee share

                    // Calculate Withholding Tax
                    $gross = $row['rate'] * $row['total_hr'];
                    if ($gross <= 250000) {
                        $withholding_tax = 0;
                    } elseif ($gross <= 400000) {
                        $withholding_tax = ($gross - 250000) * 0.15;
                    } elseif ($gross <= 800000) {
                        $withholding_tax = ($gross - 400000) * 0.20 + 22500;
                    } elseif ($gross <= 2000000) {
                        $withholding_tax = ($gross - 800000) * 0.25 + 102500;
                    } elseif ($gross <= 8000000) {
                        $withholding_tax = ($gross - 2000000) * 0.30 + 402500;
                    } else {
                        $withholding_tax = ($gross - 8000000) * 0.35 + 2202500;
                    }

                    // Fetch Cash Advance Amount for the employee
                    $casql = "SELECT SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
                    $caquery = $conn->query($casql);
                    $carow = $caquery->fetch_assoc();
                    $cashadvance = $carow['cashamount'] ?? 0; // Use the fetched cash advance amount or default to 0 if not found

                    $total_deduction = $sss_contribution + $philhealth_contribution + $withholding_tax;
                    $net = $gross - $total_deduction - $cashadvance;

                    echo "
                        <tr>
                            <td>" . $row['lastname'] . ", " . $row['firstname'] . "</td>
                            <td>" . $row['employee_id'] . "</td>
                            <td>" . number_format($gross, 2) . "</td>
                            <td>" . number_format($sss_contribution, 2) . "</td>
                            <td>" . number_format($philhealth_contribution, 2) . "</td>
                            <td>" . number_format($withholding_tax, 2) . "</td>
                            <td>" . number_format($cashadvance, 2) . "</td>
                            <td>" . number_format($net, 2) . "</td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
