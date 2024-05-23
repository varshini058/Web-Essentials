<?php

include 'config.php';

session_start();

$user_id = $_SESSION['userid'];
if(!isset($user_id)){
    header('location:login.php');
 }
 if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `bookmarks` WHERE bk_id = '$delete_id'") or die('query failed');
   header('location:bookmark.php');
}
 ?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe</title>
 
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
 </head>

 <body>
    
 <?php include 'header.php'; ?>
 <div class="heading">
   <h3>Bookmarked Recipes</h3>
   <p> <a href="home.php">Home</a> / Bookmarks </p>
</div>
<section class="recipes">
<div class="card-container">
    <?php  
         $select_recipes = mysqli_query($conn, "SELECT * FROM bookmarks b INNER JOIN recipes r ON b.recipe_id = r.recipe_id WHERE b.user_id = $user_id") or die('query failed');
         if(mysqli_num_rows($select_recipes) > 0){
            while($fetch_recipes = mysqli_fetch_assoc($select_recipes)){
      ?>

      <div class="card">
      <img src="images\<?php echo $fetch_recipes['image']; ?>" height="150px" width="150px" alt="image" style="object-fit:fill;">
      <p class="name" style="font-size:40px;color:blueviolet;font-weight:bold;"><?php echo $fetch_recipes['name']; ?></p>
      <button class="btn-edit"><a href="recipecontent.php?recipeid=<?php echo $fetch_recipes['recipe_id']; ?>">Cook</a></button>
      <button class="btn-delete"><a href="bookmark.php?delete=<?php echo $fetch_recipes['bk_id']; ?>" onclick="return confirm('Delete bookmark?');">Delete</a></button>
      </div>
    <?php
         }
      }else{
         echo '<p class="empty">Our chefs are cooking!</p>';
      }
      ?>
      </div>
</section>

</body>
</html>