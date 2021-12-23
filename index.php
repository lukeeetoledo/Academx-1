<?php

include 'config.php';
session_start();

error_reporting(0);
if (isset($_SESSION["user_id"])) {
  header("location: home.php");
}

if (isset($_POST["signup"])) {
  $firstName = mysqli_real_escape_string($conn, $_POST["regis_fname"]);
  $lastName = mysqli_real_escape_string($conn, $_POST["regis_lname"]);
  
  if(!empty($_POST['regis_sex'])) {
    $sex = mysqli_real_escape_string($conn, ($_POST["regis_sex"]));
} else {
    echo 'Please select the value.';
}
  $age = mysqli_real_escape_string($conn, ($_POST["regis_age"]));
  $email = mysqli_real_escape_string($conn, ($_POST["regis_email"]));
  $username = mysqli_real_escape_string($conn, ($_POST["regis_username"]));
  $password = mysqli_real_escape_string($conn, md5($_POST["regis_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["regis_cpassword"]));
  $contactNumber = mysqli_real_escape_string($conn, ($_POST["regis_contactnumber"]));
  $token =  mysqli_real_escape_string($conn, (md5(date("Y-m-d").$email)));

  $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users_tbl WHERE email='$email'"));
  

  if ($password !== $cpassword) {
    echo "<script>alert('Password did not match.');</script>";
  } elseif ($check_email > 0) {
    echo "<script>alert('Email already exists in out database.');</script>";
  } else {
    
    $sql = "INSERT INTO users_tbl (fname, lname, sex, age, email, username, password, contactnumber, token) 
            VALUES ('$firstName', '$lastName', '$sex', '$age', '$email', '$username','$password','$contactNumber','$token');
            INSERT INTO users_img (ID) SELECT ID FROM users_tbl WHERE email='$email';
            UPDATE users_img, users_tbl SET users_img.profile_image='img/default_img.png', users_img.bio='No bio.' WHERE users_img.ID=users_tbl.ID;";     
    $result = mysqli_multi_query($conn, $sql);

    if ($result) {
      $_POST["regis_fname"] = "";
      $_POST["regis_lname"] = "";
      $_POST["regis_sex"] = "";
      $_POST["regis_age"] = "";
      $_POST["regis_email"] = "";
      $_POST["regis_username"] = "";
      $_POST["regis_password"] = "";
      $_POST["regis_cpassword"] = "";
      $_POST["regis_contactnumber"] = "";
      echo "<script>alert('User registered.');</script>";
    }else{
      echo "<script>alert('User registration failed');</script>";
     
    }
  } 

}

if (isset($_POST["login"])) {
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $username = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["password"]));
  
  $check_email = mysqli_query($conn, "SELECT ID FROM users_tbl WHERE password = '$password' AND email='$email'");
  $check_username = mysqli_query($conn, "SELECT ID FROM users_tbl WHERE password = '$password' AND username= '$username'");

  if (mysqli_num_rows($check_email) > 0 || mysqli_num_rows($check_username) > 0) 
  {
    if (mysqli_num_rows($check_email) > 0){
      $row = mysqli_fetch_assoc($check_email);
      $_SESSION["user_id"] = $row['ID'];
      header("Location: home.php");
    }else if(mysqli_num_rows($check_username) > 0){
      $row = mysqli_fetch_assoc($check_username);
      $_SESSION["user_id"] = $row['ID'];
      header("Location: home.php");
    }
  } else {
    echo "<script>alert('Login details is incorrect. Please try again.');</script>";
  }
 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style_index.css" />
  <title>Log in and Registration</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="post" class="sign-in-form">
          <h2 class="title">Log in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Enter Email Address Or Username" name="email" value="<?php echo $_POST['email']; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required />
          </div>
          <input type="submit" value="login" name="login" class="btn solid" />
          <p style="display: flex;justify-content: center;align-items: center;margin-top: 20px;"><a href="forgot-password.php" style="color: #4590ef;">Forgot Password?</a></p>
         </form>
        <!-- register -->
        <form action="" class="sign-up-form" method="post">
          <h2 class="title">Register</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="First Name" name="regis_fname" value="<?php echo $_POST["regis_fname"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Last Name" name="regis_lname" value="<?php echo $_POST["regis_lname"]; ?>" required />
          </div>
          <div class="input-radio">
            <i class="fas fa-user" style= "margin-right: 10px; margin-left: 8px;"></i>
            <input type="radio" style= "margin-right: 5px; margin-left: 1px;" name="regis_sex" required value="Male" />Male
            <input type="radio" style= "margin-left: 40px; margin-right: 5px" name="regis_sex" required value="Female"/>Female
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Age" name="regis_age" value="<?php echo $_POST["regis_age"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email Address" name="regis_email" value="<?php echo $_POST["regis_email"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="text" placeholder="Username" name="regis_username" value="<?php echo $_POST["regis_username"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="regis_password" value="<?php echo $_POST["regis_password"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="regis_cpassword" value="<?php echo $_POST["regis_cpassword"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="text" placeholder="Contact Number" name="regis_contactnumber" value="<?php echo $_POST["regis_contactnumber"]; ?>" required />
          </div>
          <input type="submit" class="btn" name="signup" value="Sign up" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>
            What are you waiting for? Join Us!
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up 
          </button>
          
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
            laboriosam ad deleniti.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Login
          </button>
        </div>
        <img src="img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="app.js"></script>
</body>

</html>