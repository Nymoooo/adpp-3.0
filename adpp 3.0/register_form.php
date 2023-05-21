<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists!';
   } else {
      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      } else {
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         if(mysqli_query($conn, $insert)){
            header('location:login_form.php');
         } else {
            $error[] = 'Database error: '.mysqli_error($conn);
         }
      }
   }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      
      <h3>Register Now</h3>
      <img src="logo.png" >
      
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Enter your name">
      <input type="email" name="email" required placeholder="Enter your email">
  

      <div style="position: relative;">
    <input type="password" name="password" id="password" required placeholder="Enter your password">
    <input type="password" name="cpassword" id="cpassword" required placeholder="Confirm your password">
    <button type="button" onclick="showPassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
        Show password
    </button>
</div>

<script>
    function showPassword() {
        var passwordField = document.getElementById("password");
        var cpasswordField = document.getElementById("cpassword");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            cpasswordField.type = "text";
        } else {
            passwordField.type = "password";
            cpasswordField.type = "password";
        }
    }
</script>

      <select name="user_type">
         <option value="user">STUDENT</option>
         <option value="admin">PROFESSOR</option>
      </select>
      <input type="submit" name="submit" value="Register" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login Now</a></p>
   </form>

</div>

</body>
</html>
