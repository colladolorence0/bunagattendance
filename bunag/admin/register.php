<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    
    body{
    font: 14px sans-serif;
    text-align: center;
    background-size: cover;
    background-attachment: fixed;
 
}
.container{
    max-width: 500px;
    margin: 0 auto;
    margin-top: 50px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    background-color: rgba(255,255,255,0.8); /* Add a semi-transparent white background to the container */
    backdrop-filter: blur(2px); /* Add a blur effect to the container background */
  
}
        .container{
            max-width: 500px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            
        }
        h1{
            font-size: 3rem;
            margin-bottom: 50px;
        }
        .form-group{
            margin-bottom: 20px;
        }
        .btn-primary{
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover{
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-5">Register</h1>

                <form action="register_action.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>First Name</label>
        <input type="text" name="firstname" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="lastname" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>