<?php
session_start();
include 'conn.php'; // Include your database connection file

if (isset($_POST['login'])) {
    $employee_id = $_POST['employee_id'];
    $password = $_POST['password'];

    // Perform validation and check credentials in the database
    // Assuming you have a table named 'employees' with columns 'employee_id' and 'password'
    $sql = "SELECT * FROM employees WHERE employee_id = '$employee_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION['employee_id'] = $employee_id;
        header('Location: employee_dashboard.php');
        exit();
    } else {
        $error_message = "Invalid employee ID or password";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap">
    <link rel="shortcut icon" href="./logo222.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <style>
        body {
            background-image: url(slide3.JPG);
            background-position: center;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333; /* Change navbar background color */
            color: #fff;
            border-radius: 0;
            padding: 15px 0; /* Adjust padding to increase navbar height */
            border-bottom: 0px solid #000; /* Add border to bottom */
            position: fixed; /* Fix navbar position */
            top: 0; /* Position at the top */
            left: 0; /* Position at the left */
            width: 100%; /* Full width */
            z-index: 1000; /* Ensure it's on top of other content */
            transition: all 0.3s ease;
        }

        .navbar-header {
            padding: 10px;
            display: inline-block;
        }

        .navbar-brand img {
            max-width: 250px;
            height: auto;
            margin: 6px; /* Center the logo horizontally */
            display: block; /* Ensure the logo is a block element */
        }

        .navbar-toggler {
            border-color: transparent !important; /* Remove blue line color */
        }

        .navbar-nav li a {
            color: #fff !important;
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .prev-btn,
        .next-btn {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
            border-radius: 10%;
            width: 50px;
            height: 50px;
            text-align: center;
            line-height: 30px;
            font-size: 30px;
            cursor: pointer;
            z-index: 1001;
        }

        .prev-btn {
            left: 20px;
        }

        .next-btn {
            right: 20px;
        }

        @keyframes slideshow {
            0% {
                background-image: url(slide1.JPG);
            }

            33% {
                background-image: url(slide2.JPG);
            }

            66% {
                background-image: url(slide3.JPG);
            }
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 370px;
            width: 100%;
            margin: auto; /* Center the login container horizontally */
        }

        input[type="text"],
        input[type="password"],
        button {
            padding: 10px;
            margin: 5px;
            border-radius: 1px;
            border: 1px solid #ccc;
            width: calc(100% - 20px); /* Adjusted width to accommodate padding and margin */
            box-sizing: border-box;
            font-size: 16px; /* Adjusted font size */
        }

        button {
            background-color: #007bff; /* Change button background color */
            color: #fff; /* Change button text color */
            cursor: pointer;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        @media only screen and (min-width: 768px) {
            body {
                justify-content: flex-end;
            }

            .login-container {
                margin-right: 120px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-black">
    <a class="navbar-brand" href="#"><img src="./bunaglogo.png" alt="Company Logo"></a>
   
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<div class="login-container">
    <h1>Employee Login</h1>
    <form action="" method="POST">
        <label for="employee_id">Employee ID:</label>
        <input type="text" id="employee_id" name="employee_id" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>

    <?php
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>

    <a href="index.php"><button>Back to Home</button></a>
</div>

</body>
</html>
