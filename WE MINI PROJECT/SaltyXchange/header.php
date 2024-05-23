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

<header class="header">
   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
         </div>
         <p> New User <a href="login.php">Login</a> | <a href="register.php">Register</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Salty<span style="color:orange">X</span>change</a>

         <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="recipes.php">Recipes</a>
            <a href="bookmark.php">Bookmarks</a>
            <a href="profile.php">Profile</a>
         </nav>

         <div class="icons">
            <a href="search.php" class="fas fa-search"></a>
            <a href="logout.php" class="fa-solid fa-right-from-bracket"></a>
         </div>
      </div>
   </div>

</header>