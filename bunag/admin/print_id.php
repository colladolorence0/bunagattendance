<?php
// Include your database connection file
require 'db.php';

// Check if the employee ID is set in the URL
if (isset($_GET['id'])) {
    // Fetch the employee data from the database including the position description
    $sql = "SELECT e.*, p.description AS position_description FROM employees e LEFT JOIN position p ON e.position_id = p.id WHERE e.id = :employeeId";
    $statement = $pdo->prepare($sql);
    $statement->execute(['employeeId' => $_GET['id']]);
    $employeeData = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if employee data exists
    if ($employeeData) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print and Download Employee ID Card</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI';
            font-size: 12px;
            background-color: #f0f0f0;
        }

        .container-wrapper {
            display: flex;
            justify-content: space-between;
            width: 110mm;
            margin: 20px auto;
        }

        .container {
            width: 55mm;
            height: 87mm;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section {
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .front {
            background-image: url('/bunag/front.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .back {
            background-image: url('/bunag/back.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .photo-container {
            margin-bottom: 5px;
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-top: 15px;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .text-info {
            font-size: 14px;
            margin-bottom: 50px;
            text-align: center;
            color: #333333;
        
        }

        .description {
            font-weight: bold;
            font-size: 90%;
        }

        .additional-info {
            margin-top: 10px;
            text-align: center;
        }

        .print-download-btns {
            text-align: center;
            margin-top: 15px;
        }

        .btn {
            margin-right: 10px;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Hide buttons when printing */
        @media print {
            .print-download-btns {
                display: none;
            }
            
            /* Enable background images in print */
            .front,
            .back {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Company logo */
        .front .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 30px;
            height: 30px;
            background-image: url("../images/bunaglogo.png");
            background-size: cover;
        }

        .qr-code-container {
            margin-top: 15px;
        }

        .photo-container {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <!-- Flex container for both ID cards -->
    <div class="container-wrapper" id="htmlContent">
        <!-- Front of the ID card container -->
        <div class="container front">
            <div class="section">
                <div class="logo"></div>
                <div class="photo-container photo">
                    <!-- Replace the image source with the appropriate URL -->
                    <img src="../images/<?= $employeeData['photo'] ?>" alt="Employee Photo">
                </div>
                <div class="text-info">
                    <span class="description"></span> <?= $employeeData['firstname'] ?> <?= $employeeData['lastname'] ?><br>
                    <span class="description">Employee ID:</span> <?= $employeeData['employee_id'] ?><br>
                    <span class="description">Position:</span> <?= $employeeData['position_description'] ?>
                </div>
            </div>
        </div>

        <!-- Back of the ID card container -->
        <div class="container back">
            <div class="section">
                <div class="qr-code-container">
                    <!-- Replace the image source with the appropriate URL -->
                    <img src="../admin/images/<?= $employeeData['qrtext'] ?>" alt="QR Code Image">
                </div>
                <div class="additional-info">
                    <div class="text-info">
                        <span class="description">Address:</span> <?= $employeeData['address'] ?><br>
                        <span class="description">Contact Info:</span> <?= $employeeData['contact_info'] ?><br>
                        <span class="description">Birthdate:</span> <?= date('F d, Y', strtotime($employeeData['birthdate'])) ?>

</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print and Download buttons -->
    <div class="print-download-btns">
    <input type="button" id="btnPrint" onclick="window.print();" value="Print Page" class="btn">
   
    <a href="employee.php" class="btn">Back</a>
</div>


</body>
</html>


<?php
    } else {
        echo "Employee not found!";
    }
} else {
    echo "Employee ID not provided!";
}
?>
