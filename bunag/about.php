<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>About-Bunag-Carlos Builders</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="shortcut icon" href="./logo222.png" type="image/x-icon">

 
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif; /* Restoring font family */
    }

    .nav-link {
      font-size: 23px;
    }

    .navbar {
      background-color: #333;
      color: #fff;
      border-radius: 0;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      transition: all 0.3s ease;
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
      color: #fff!important;
    }

    .container {
      padding-top: 100px; /* Reduced padding for container */
      padding-bottom: 50px;
    }

    .about-section {
      background-color: #fff;
      border-radius: 6px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-top: 50px;
      max-width: 1000px;
      margin-left: auto;
      margin-right: auto;
      display: flex; /* Added flex display */
    }

    .about-content {
      flex: 1; /* Added flex property to take up remaining space */
    }

    .company-owner {
      width: 300px; /* Adjust width as needed */
      margin-left: 30px; /* Added margin for spacing */
      text-align: center;
    }

    .card {
      text-align: center;
    }

    .card-img-top {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      object-fit: cover;
      margin: 0 auto 20px auto;
    }

    .btn {
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px 20px;
      text-transform: uppercase;
      font-weight: bold;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #444;
    }

    /* Added margin to Vision, Mission, and Philosophy */
    h2 {
      margin-top: 40px;
      margin-bottom: 20px;
    }

    p {
      line-height: 1.5;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-black">
    <a class="navbar-brand" href="index.php"><img src="./bunaglogo.png" alt="Company Logo" style="max-width: 250px; height: auto;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="employee_login.php">Log in</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- About Us Content -->
  <div class="container">
    <div class="about-section">
      <div class="about-content">
        <h1 class="display-4">About Us</h1>
        <p class="lead">Bunag-Carlos Builders is a general construction and engineering services company that aims to meet the specific needs and increasing demand of the country's construction industry. We undertake various infrastructure and development projects in the private, local government units, and national government sectors.</p>
        <hr class="my-4">
        <p>We are duly accredited by the Philippine Contractors Accreditation Board (PCAB) with registration number 35252.</p>
      </div>
      <div class="company-owner">
        <div class="card">
          <img class="card-img-top" src="owner.jpg" alt="Zenaida F. Carlos">
          <div class="card-body">
            <h4 class="card-title">Zenaida F. Carlos</h4>
            <p class="card-text">General Manager</p>
            <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=zenaida.carlos@yahoo.com.ph" target="_blank" class="btn">Contact</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Vision -->
    <h2>Vision</h2>
    <p>To be recognized as one of the well-established and respected construction companies in the country and eventually outside the Philippines.</p>

    <!-- Mission -->
    <h2>Mission</h2>
    <p>With the best services at the most prudent costing and the fairest profits, we will provide benefit and satisfaction to our clients, focusing on its three core values – SPEED, QUALITY, and COST, to ascertain our ultimate success with pride and dignity.</p>

    <!-- Philosophy -->
    <h2>Philosophy</h2>
    <p>Our commitment is the satisfaction of our client and value their investment.</p>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
