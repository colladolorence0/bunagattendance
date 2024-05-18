<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

$employee_id = $_SESSION['employee_id'];
$sql = "SELECT firstname, lastname, photo, position_id, contact_info,id FROM employees WHERE employee_id = '$employee_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    // Check if the photo field is not empty and the file exists in the "images" folder
    $photo = (!empty($row['photo']) && file_exists('images/' . $row['photo'])) ? 'images/' . $row['photo'] : 'images/default_photo.jpg';
    $position_id = $row['position_id'];
    $contact_info = $row['contact_info'];
} else {
    $firstname = 'Unknown';
    $lastname = 'Employee';
    $photo = 'images/default_photo.jpg'; // Set a default photo path if none is provided
    $position_id = '';
    $contact_info = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./logo222.png" type="image/x-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #333;
      color: #fff;
      border-radius: 0;
      position: fixed; /* Fix navbar position */
      top: 0; /* Position at the top */
      left: 0; /* Position at the left */
      width: 100%; /* Full width */
      z-index: 1000; /* Ensure it's on top of other content */
    }

    .navbar-header {
      padding: 10px;
      display: inline-block;
    }

    .navbar-brand img {
      max-width: 250px;
      height: auto;
      margin: 0;
    }

    .navbar-nav li a {
      color: #fff !important;
    }

    .sidenav {
      background-color: #f5f5f5;
      padding-top: 20px;
      border-right: 1px solid #ddd; /* Thin border on the right side */
      position: fixed; /* Fix position for the sidebar */
      top: 70px; /* Position below the navbar */
      left: 0; /* Position at the left */
      width: 300px; /* Set a wider fixed width */
      overflow-y: auto; /* Enable vertical scrolling if needed */
      z-index: 900; /* Ensure it's below the navbar */
      height: calc(100% - 70px); /* Adjust height to fit remaining space */
    }

    .profile-info {
      text-align: center;
      padding-bottom: 20px;
      border-bottom: 1px solid #ddd;
      margin-bottom: 20px;
    }

    .profile-photo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #222;
      margin-bottom: 10px;
    }

    .profile-name {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333; /* Changed text color */
    }

    .nav-pills>li.active>a,
    .nav-pills>li.active>a:hover,
    .nav-pills>li.active>a:focus {
      background-color: #333;
    }

    .content {
      padding: 20px;
      margin-top: 120px; /* Adjust content margin to move it downwards */
      margin-left: 300px; /* Adjust content margin to accommodate the wider sidebar */
    }

    .widget {
      background-color: #fff;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .widget h4 {
      margin-top: 0;
      margin-bottom: 15px;
      font-size: 28px; /* Increased font size for the welcome text */
      color: #333; /* Changed text color */
    }

    .widget p {
      margin-bottom: 15px;
    }

    .widget ul {
      padding-left: 20px;
    }

    .widget ul li {
      margin-bottom: 5px;
    }

    .profile-logout {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    .profile-logout a {
      display: inline-block;
      padding: 12px 30px; /* Increased padding */
      background-color: #333;
      color: #fff;
      border-radius: 0 0 5px 5px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      font-size: 16px; /* Increased font size */
      font-weight: bold; /* Bold font weight */
    }

    .profile-logout a:hover {
      background-color: #555;
    }

    /* Custom class for the "View Record" buttons */
    .custom-btn {
      background-color: #333; /* Same color as the Dashboard button */
      color: #fff !important;
      border-color: #333; /* Same border color as the Dashboard button */
    }

    .custom-btn:hover,
    .custom-btn:focus {
      background-color: #555; /* Darker color on hover */
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="bunaglogo.png" alt="Company Logo"></a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <!-- Move the logout link here -->
      <li class="profile-logout"><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 sidenav">
      <div class="profile-info">
        <?php if (!empty($photo)) : ?>
          <img src="<?php echo $photo; ?>" alt="Profile Photo" class="profile-photo">
        <?php endif; ?>
        <div class="profile-name"><?php echo $firstname . ' ' . $lastname; ?></div>
      </div>
      <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'employee_dashboard.php') ? 'active' : ''; ?>">
          <a href="employee_dashboard.php" style="text-align: center; display: block;">Dashboard</a>
        </li>
        <li>
          <a href="view_employee_records.php" class="btn btn-primary view-btn custom-btn" data-target="view_employee_records.php">
            <span style="display: inline-block; text-align: center; width: 100%;">View Employee Records</span>
          </a>
        </li>
        <li>
          <a href="view_attendance_records.php?id=<?php echo $employee_id; ?>&id2=<?php echo $id; ?>" class="btn btn-primary view-btn custom-btn" data-target="view_attendance_records.php?id=<?php echo $employee_id; ?>&id2=<?php echo $id; ?>">
            <span style="display: inline-block; text-align: center; width: 100%;">View Attendance Records</span>
         </a>
        </li>
        <li>
    <a href="view_payroll.php?id=<?php echo $employee_id; ?>&id2=<?php echo $id; ?>" class="btn btn-primary view-btn custom-btn" data-target="view_payroll.php?id=<?php echo $employee_id; ?>&id2=<?php echo $id; ?>">
        <span style="display: inline-block; text-align: center; width: 100%;">View Payroll</span>
    </a>
</li>

      </ul>
      <br>
    </div>
    <div class="col-sm-9 content">
      <div class="widget">
        <h4 style="font-size: 36px; color: #333;">Welcome to Your Dashboard</h4>
        <p>Hello <?php echo $firstname; ?>!</p>
      </div>
    </div>
  </div>
</div>

<!-- Add this script at the end of your HTML body -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var viewBtns = document.querySelectorAll('.view-btn');
    viewBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default behavior of anchor tags
            var target = this.getAttribute('data-target');
            loadContentView(target);
        });
    });

    function loadContentView(targetUrl) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector('.content').innerHTML = this.responseText;
                // Scroll to the top of the content area
                document.querySelector('.content').scrollIntoView({ behavior: 'smooth' });
            }
        };
        xhttp.open("GET", targetUrl, true);
        xhttp.send();
    }
});
</script>

</body>
</html>