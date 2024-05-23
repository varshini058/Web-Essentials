<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email =mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn,$_POST['password']);

   $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

         $_SESSION['username'] = $row['username'];
         $_SESSION['email'] = $row['email'];
         $_SESSION['userid'] = $row['user_id'];
         header('location:home.php');

   }else{
      $message[] = 'Incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Login now</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="submit" name="submit" value="login now" class="btn">
      <p>New chef to the place? <a href="register.php">Register now</a></p>
   </form>

</div>

</body>
</html>