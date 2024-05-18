<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Bunag-Carlos Builders Attendance System</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="shortcut icon" href="./logo222.png" type="image/x-icon">

  <style>
    body {
      background-image: url(slide2.JPG);
      background-position: center;
      background-size: cover;

    }

    @keyframes slideshow {
      0% {background-image: url(slide1.JPG);}
      33% {background-image: url(slide2.JPG);}
      66% {background-image: url(slide3.JPG);}
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh; /* Make sure the container takes up the full viewport height */
    }

    .login-box {
      width: 400px; /* Adjust the width of the login box as needed */
      background-color: white; /* Set a background color for the login box */
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow effect */
    }

    .nav-link {
      font-size: 23px; /* Adjust the font size as needed */
    }

    .form-group.has-feedback .form-control-feedback {
      position: absolute;
      right: -12px;
      top: 0;
      line-height: 29px;
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
      color: #fff !important;
    }

    .row {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .prev-btn, .next-btn {
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
  </style>
</head>
<body>

 <!-- Previous and next buttons for slideshow -->
  <button class="prev-btn" onclick="prevSlide()">&lt;</button>
  <button class="next-btn" onclick="nextSlide()">&gt;</button>

  <!-- Header for log in admin// -->
  <nav class="navbar navbar-expand-lg navbar-light bg-black">
    <a class="navbar-brand" href="#"><img src="./bunaglogo.png" alt="Company Logo" style="max-width: 250px; height: auto;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
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


  <!-- Centered container for the QR code scanner -->
  <div class="container">
    <div class="login-box">
      <div class="login-logo">
        <p id="date"></p>
        <p id="time" class="bold"></p>
      </div>
    
      <div class="login-box-body">
        <h4 class="login-box-msg">SCAN QR CODE</h4>

        <form action="employee_login.php" method="POST"> <!-- Updated form action -->
          <div class="form-group">
            <select class="form-control" name="status">
              <option value="in">TIME IN</option>
              <option value="out">TIME OUT</option>
            </select>
          </div>
          <div class="form-group has-feedback">
            <video id="qr-video" width="100%" height="auto"></video>
            <span class="glyphicon glyphicon-camera form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
             <button type="button" class="btn btn-primary btn-block btn-flat" id="scan-qr"><i class="fa fa-camera"></i> Scan QR Code</button>
            </div>
          </div>
        </form>
      </div>
      <div class="alert alert-success alert-dismissible mt20 text-center" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="result"><i class="icon fa fa-check"></i> <span class="message"></span></span>
      </div>
      <div class="alert alert-danger alert-dismissible mt20 text-center" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
      </div>
    </div>
  </div>
  
  <?php include 'scripts.php'; ?>

  <!-- Your HTML code -->


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.0.1/jsQR.min.js"></script> <!-- Include jsQR library -->
<!-- Include jsQR library -->
<script>


    document.addEventListener('DOMContentLoaded', function() {
      const navbarToggler = document.querySelector('.navbar-toggler');
      const navbarCollapse = document.querySelector('.navbar-collapse');

      navbarToggler.addEventListener('click', function() {
        if (!navbarCollapse.classList.contains('show')) {
          navbarCollapse.classList.add('show');
        } else {
          navbarCollapse.classList.remove('show');
        }
      });
    });
  let currentSlide = 0;

  function nextSlide() {
    currentSlide = (currentSlide + 1) % 3;
    updateBackground();
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + 3) % 3;
    updateBackground();
  }

  function updateBackground() {
    let images = ['slide1.JPG', 'slide2.JPG', 'slide3.JPG'];
    document.body.style.backgroundImage = `url(${images[currentSlide]})`;
  }

  $(function() {
    const video = document.getElementById('qr-video');
    let scanning = false;

    function startScanning() {
      navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
        .then(function(stream) {
          video.srcObject = stream;
          video.play();
          scanning = true;
        })
        .catch(function(err) {
          console.error('Error accessing camera:', err);
        });
    }

    function stopScanning() {
      video.srcObject.getTracks().forEach(track => track.stop());
      scanning = false;
    }

    $('#scan-qr').click(function() {
      if (scanning) {
        stopScanning();
        $(this).text('Scan QR Code');
      } else {
        startScanning();
        $(this).text('Stop Scanning');
      }
    });

    video.addEventListener('loadedmetadata', function() {
      const canvas = document.createElement('canvas');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const context = canvas.getContext('2d');

      function scanQRCode() {
        if (!scanning) return;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: 'dontInvert',
        });

        if (code) {
          // Handle time in and time out based on status selected
          const status = $('select[name="status"]').val();
          $.ajax({
            type: 'POST',
            url: 'attendance.php',
            data: { employee: code.data, status: status },
            dataType: 'json',
            success: function(response){
              if(response.error){
                $('.alert').hide();
                $('.alert-danger').show();
                $('.message').html(response.message);
              }
              else{
                $('.alert').hide();
                $('.alert-success').show();
                $('.message').html(response.message);
                $('#employee').val('');
              }
            }
          });
          stopScanning();
          $('#scan-qr').text('Scan QR Code');
        }

        requestAnimationFrame(scanQRCode);
      }

      scanQRCode();
    });
  });
</script>

</body>
</html>